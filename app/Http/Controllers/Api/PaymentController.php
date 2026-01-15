<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        // Buat Order ID Unik
        $orderId = 'POS-'.time().'-'.rand(100, 999);

        // Simpan dulu ke Database (Status: Pending)
        $trx = new Transaction();
        $trx->order_id = $orderId;
        $trx->amount = $request->amount;
        $trx->status = 'pending';
        $trx->save();

        // Siapkan Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => "Customer",
                'email' => "guest@pos-system.com",
            ]
        ];

        try {
            // Minta Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update token ke database
            $trx->snap_token = $snapToken;
            $trx->save();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        // Log notifikasi masuk (untuk debugging di hosting)
        Log::info('Midtrans Webhook:', $request->all());

        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Ambil data notifikasi
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $reqSignature = $request->signature_key;

        // Validasi Signature (Cek Keaslian Data)
        // Rumus: SHA512(order_id + status_code + gross_amount + ServerKey)
        $signature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($signature !== $reqSignature) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // Cek Status Transaksi
        $transactionStatus = $request->transaction_status;
        $trx = Transaction::where('order_id', $orderId)->first();

        if (! $trx) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $trx->status = 'paid';
            $trx->payment_type = $request->payment_type;
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $trx->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $trx->status = 'pending';
        }

        $trx->save();

        return response()->json(['message' => 'Callback received']);
    }
}