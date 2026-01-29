@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daftar Booking</h1>
            <p class="text-gray-500">Kelola semua pesanan masuk di sini.</p>
        </div>
        <!-- Optional: Filter Button or Export -->
    </div>
    
    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('admin.bookings.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-gray-700">
                                Tgl Booking
                                @if(request('sort') == 'created_at')
                                    <span>{{ request('direction') == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('admin.bookings.index', ['sort' => 'event_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-gray-700">
                                Tgl Event
                                @if(request('sort', 'event_date') == 'event_date')
                                    <span>{{ request('direction', 'desc') == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Paket</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">{{ $booking->created_at->timezone('Asia/Makassar')->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->event_date)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->event_time)->format('H:i') }} WITA</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900">{{ $booking->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->customer_phone }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">{{ $booking->package_name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->duration_hours }} Jam</div>
                        </td>
                         <td class="py-4 px-6 text-sm font-medium text-gray-900">
                            Rp {{ number_format($booking->price_total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" id="status-form-{{ $booking->id }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="document.getElementById('status-form-{{ $booking->id }}').submit()" 
                                    class="text-xs font-bold rounded-full px-3 py-1 border-0 cursor-pointer focus:ring-2 focus:ring-yellow-400
                                    {{ $booking->status == 'LUNAS' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status == 'DP_DIBAYAR' ? 'bg-blue-100 text-blue-800' : 
                                       ($booking->status == 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    <option value="PENDING" {{ $booking->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                    <option value="DP_DIBAYAR" {{ $booking->status == 'DP_DIBAYAR' ? 'selected' : '' }}>DP DIBAYAR</option>
                                    <option value="LUNAS" {{ $booking->status == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                                    <option value="DIBATALKAN" {{ $booking->status == 'DIBATALKAN' ? 'selected' : '' }}>DIBATALKAN</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-right">
                           <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->customer_phone) }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm font-medium">
                               Chat WA
                           </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">Belum ada data booking.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
@endsection