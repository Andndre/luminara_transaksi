<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_replace('/', '_', $invoice->invoice_number) }}_{{ $invoice->customer_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900 p-8 md:p-12 relative">

    @if(session('success'))
        <div id="toast-success" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-full shadow-xl flex items-center gap-2 z-50 no-print print:hidden transition-all duration-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    @if(session('auto_print') || request()->has('print'))
        <script>
            window.onload = function() {
                setTimeout(() => {
                    window.print();
                    if (window.location.search.includes('print=1')) {
                        window.close();
                    }
                }, 500);
            }
        </script>
    @endif

    <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-lg shadow-lg relative">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b pb-8 mb-8">
            <div>
                @php
                    $unitName = $invoice->booking && $invoice->booking->business_unit == 'visual' ? 'Visual' : 'Photobooth';
                @endphp
                <div class="flex items-center gap-3 mb-4">
                    <img src="/images/Logo Luminara Visual-BLACK-TPR.png" alt="Luminara" class="h-12">
                    <div class="border-l-2 border-gray-300 pl-3">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Luminara</h2>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $unitName }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">
                    Jl. Sultan Agung No.9X, Karangasem<br>
                    Bali, Indonesia 80811<br>
                    WhatsApp: 0877-8898-6136
                </p>
            </div>
            <div class="text-right">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">INVOICE</h1>
                <p class="text-lg text-gray-600 font-medium">#{{ $invoice->invoice_number }}</p>
                <p class="text-sm text-gray-500 mt-1">Tanggal: {{ $invoice->invoice_date->format('d F Y') }}</p>
                
                @if($invoice->balance_due <= 0)
                    <div class="mt-4 inline-block px-4 py-1 bg-green-100 text-green-700 text-sm font-bold uppercase tracking-wider rounded border border-green-200">
                        LUNAS
                    </div>
                @elseif($invoice->dp_amount > 0)
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
            <h2 class="text-xl font-bold text-gray-900">{{ $invoice->customer_name }}</h2>
            <p class="text-gray-600">{{ $invoice->customer_phone }}</p>
            @if($invoice->customer_address)
                <p class="text-gray-600">{{ $invoice->customer_address }}</p>
            @elseif($invoice->booking && $invoice->booking->event_location)
                <p class="text-gray-600">{{ $invoice->booking->event_location }}</p>
            @endif
        </div>

        <!-- Details -->
        <div class="mb-10">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Detail Layanan:</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase border-b border-gray-200">
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4 text-center">Qty</th>
                        <th class="py-3 px-4 text-right">Harga</th>
                        <th class="py-3 px-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($invoice->items as $item)
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4 font-medium text-gray-900">
                            {{ $item->description }}
                            @if($item->is_bonus)
                                <span class="ml-2 text-[10px] bg-green-100 text-green-800 px-2 py-0.5 rounded-full font-bold">BONUS</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">{{ $item->quantity }}</td>
                        <td class="py-4 px-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 text-right font-bold">
                            @if($item->is_bonus)
                                FREE
                            @else
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-right text-gray-600">Subtotal</td>
                        <td class="py-3 px-4 text-right font-bold text-gray-900">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-right text-gray-600">Diskon ({{ $invoice->discount_percent + 0 }}%)</td>
                        <td class="py-2 px-4 text-right text-red-600">- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($invoice->tax_amount > 0)
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-right text-gray-600">Pajak ({{ $invoice->tax_percent + 0 }}%)</td>
                        <td class="py-2 px-4 text-right text-gray-900">Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="border-t border-gray-300">
                        <td colspan="3" class="py-4 px-4 text-right font-bold text-gray-900 text-lg">Grand Total</td>
                        <td class="py-4 px-4 text-right font-bold text-gray-900 text-lg">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->dp_amount > 0)
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-right text-gray-600">Uang Muka (DP)</td>
                        <td class="py-2 px-4 text-right font-bold text-blue-600">Rp {{ number_format($invoice->dp_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-yellow-50">
                        <td colspan="3" class="py-3 px-4 text-right font-bold text-yellow-800">Sisa Tagihan</td>
                        <td class="py-3 px-4 text-right font-bold text-red-600 text-lg">Rp {{ number_format($invoice->balance_due, 0, ',', '.') }}</td>
                    </tr>
                    @endif
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
                    @php
                        $unit = $invoice->booking && $invoice->booking->business_unit == 'visual' ? 'Visual' : 'Photobooth';
                    @endphp
                    <p class="italic text-gray-400">Terima kasih telah mempercayai Luminara {{ $unit }} untuk mengabadikan momen berharga Anda.</p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="absolute top-4 right-4 no-print print:hidden flex gap-2">
            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Invoice
            </a>
            <button onclick="window.print()" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg shadow font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / PDF
            </button>
        </div>

    </div>

</body>
</html>