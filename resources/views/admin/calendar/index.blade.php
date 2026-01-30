@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Kalender</h1>
        <p class="text-gray-500">Blokir tanggal tertentu agar tidak bisa dipesan pelanggan (misal: Libur / Full Booked Offline).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Form Block Date -->
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Blokir Tanggal Baru</h3>
                
                <form action="{{ route('admin.calendar.block') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
                        <input type="text" name="date" id="block_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required placeholder="Pilih tanggal...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan (Opsional)</label>
                        <input type="text" name="reason" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" placeholder="Contoh: Libur Nasional">
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg font-bold hover:bg-red-700 transition">
                        Blokir Tanggal
                    </button>
                </form>
            </div>
        </div>

        <!-- List Blocked Dates -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Tanggal Diblokir</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 whitespace-nowrap">Tanggal</th>
                                <th class="px-6 py-3 whitespace-nowrap">Alasan</th>
                                <th class="px-6 py-3 text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($blockedDates as $blocked)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $blocked->date->format('d/m/Y') }}
                                        <span class="text-gray-400 text-xs block">{{ $blocked->date->format('l') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 min-w-[200px]">{{ $blocked->reason ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <form action="{{ route('admin.calendar.unblock', $blocked->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmUnblock(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">Buka Blokir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">Tidak ada tanggal yang diblokir saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#block_date", {
                locale: "id",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y", // Format tampilan user: 29 Januari 2026
            });
        });

        function confirmUnblock(button) {
            Swal.fire({
                title: 'Buka Blokir?',
                text: "Tanggal ini akan tersedia kembali untuk dipesan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, buka blokir!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
@endsection
