<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invNumber }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900 p-8 md:p-12">

    <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-lg shadow-lg relative">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b pb-8 mb-8">
            <div>
                <img src="/images/logo.png" alt="Luminara" class="h-12 mb-4">
                <p class="text-sm text-gray-500">
                    Jalan Tukad Balian, Denpasar<br>
                    Bali, Indonesia 80225<br>
                    WhatsApp: 0877-8898-6136
                </p>
            </div>
            <div class="text-right">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">INVOICE</h1>
                <p class="text-lg text-gray-600 font-medium">#{{ $invNumber }}</p>
                <p class="text-sm text-gray-500 mt-1">Tanggal: {{ now()->format('d F Y') }}</p>
                
                @if($booking->status == 'LUNAS')
                    <div class="mt-4 inline-block px-4 py-1 bg-green-100 text-green-700 text-sm font-bold uppercase tracking-wider rounded border border-green-200">
                        LUNAS
                    </div>
                @elseif($booking->status == 'DP_DIBAYAR')
                    <div class="mt-4 inline-block px-4 py-1 bg-blue-100 text-blue-700 text-sm font-bold uppercase tracking-wider rounded border border-blue-200">
                        DP DIBAYAR
                    </div>
                @else
                    <div class="mt-4 inline-block px-4 py-1 bg-yellow-100 text-yellow-700 text-sm font-bold uppercase tracking-wider rounded border border-yellow-200">
                        BELUM LUNAS
                    </div>
                @endif
            </div>
        </div>

        <!-- Bill To -->
        <div class="mb-10">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tagihan Kepada:</h3>
            <h2 class="text-xl font-bold text-gray-900">{{ $booking->customer_name }}</h2>
            <p class="text-gray-600">{{ $booking->customer_phone }}</p>
            @if($booking->customer_email)
                <p class="text-gray-600">{{ $booking->customer_email }}</p>
            @endif
        </div>

        <!-- Details -->
        <div class="mb-10">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Detail Layanan:</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4 text-center">Durasi</th>
                        <th class="py-3 px-4 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4">
                            <span class="block font-bold text-gray-900">{{ $booking->package_name }}</span>
                            <span class="block text-gray-500 text-xs mt-1">Acara: {{ $booking->event_type }}</span>
                            <span class="block text-gray-500 text-xs">Lokasi: {{ $booking->event_location }}</span>
                            <span class="block text-gray-500 text-xs">Tgl: {{ $booking->event_date->format('d/m/Y') }} @ {{ \Carbon\Carbon::parse($booking->event_time)->format('H:i') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">{{ $booking->duration_hours }} Jam</td>
                        <td class="py-4 px-4 text-right font-medium">Rp {{ number_format($booking->price_total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="py-4 px-4 text-right font-bold text-gray-900">Total</td>
                        <td class="py-4 px-4 text-right font-bold text-gray-900 text-lg">Rp {{ number_format($booking->price_total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer / Payment Info -->
        <div class="border-t pt-8 text-sm text-gray-600">
            <h4 class="font-bold text-gray-900 mb-2">Informasi Pembayaran</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p>Bank BRI: <span class="font-mono font-bold text-black">460701039843530</span> (Ida Bagus Yudhi)</p>
                    <p>SeaBank: <span class="font-mono font-bold text-black">901207048574</span></p>
                </div>
                <div class="text-right">
                    <p class="italic text-gray-400">Terima kasih atas kepercayaan Anda.</p>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="absolute top-4 right-4 no-print">
            <button onclick="window.print()" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg shadow font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Simpan PDF
            </button>
        </div>

    </div>

</body>
</html>
