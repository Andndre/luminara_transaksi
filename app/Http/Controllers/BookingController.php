<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Jangan lupa baris ini

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi data (opsional tapi disarankan)
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'whatsapp' => 'required|numeric',
            'tanggal_acara' => 'required|date',
            // ... tambahkan validasi lain jika perlu
        ]);

        // 2. Simpan ke Database
        Booking::create($request->all());

        // 3. Kembalikan ke halaman awal dengan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dikirim! Admin akan segera menghubungi WhatsApp Anda.');
    }
}
