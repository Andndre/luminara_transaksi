@extends('layouts.admin')

@section('content')
    <div x-data="bookingManager()">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Daftar Booking</h1>
                <p class="text-gray-500">Kelola semua pesanan masuk di sini.</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}" class="bg-black text-white hover:bg-gray-800 font-bold py-2 px-4 rounded-lg transition shadow-sm">
                + Buat Booking Manual
            </a>
        </div>
        
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                <a href="{{ route('admin.bookings.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-gray-700">
                                    Tgl Booking
                                    @if(request('sort') == 'created_at')
                                        <span>{{ request('direction') == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                <a href="{{ route('admin.bookings.index', ['sort' => 'event_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-gray-700">
                                    Tgl Event
                                    @if(request('sort', 'event_date') == 'event_date')
                                        <span>{{ request('direction', 'desc') == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Paket</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Total</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap text-center">Bukti</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $booking->created_at->timezone('Asia/Makassar')->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->event_date)->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->event_time)->format('H:i') }} WITA</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap cursor-pointer hover:bg-yellow-50" @click="openDetail({{ $booking }})">
                                <div class="font-medium text-gray-900">{{ Str::limit($booking->customer_name, 20) }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->customer_phone }}</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ Str::limit($booking->package_name, 25) }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->duration_hours }} Jam</div>
                            </td>
                             <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($booking->price_total, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($booking->payment_proof)
                                    <button @click="openImageModal('{{ asset('storage/' . $booking->payment_proof) }}')" type="button" class="text-blue-500 hover:text-blue-700 transition" title="Lihat Bukti Transfer">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
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
                               <div class="flex items-center justify-end gap-2">
                                   <!-- Detail Button -->
                                   <button @click="openDetail({{ $booking }})" class="text-gray-600 hover:text-gray-900 text-sm font-medium" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                   </button>
                                   <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->customer_phone) }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm font-medium" title="Chat WA">
                                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                                   </a>
                                   <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                   </a>
                                   <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" class="text-gray-600 hover:text-gray-900" title="Invoice">
                                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                   </a>
                                   <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                                       @csrf
                                       @method('DELETE')
                                       <button type="button" onclick="confirmDelete(this)" class="text-red-600 hover:text-red-800" title="Hapus">
                                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                       </button>
                                   </form>
                               </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-gray-500">Belum ada data booking.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="block md:hidden divide-y divide-gray-100">
                @forelse($bookings as $booking)
                <div class="p-4 space-y-3" @click="openDetail({{ $booking }})">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Event: {{ \Carbon\Carbon::parse($booking->event_date)->format('d/m/Y') }}</div>
                            <h3 class="font-bold text-gray-900">{{ $booking->customer_name }}</h3>
                            <div class="text-xs text-blue-600 font-medium">{{ $booking->package_name }} ({{ $booking->duration_hours }} Jam)</div>
                        </div>
                        <div class="text-right" @click.stop>
                             <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" id="status-form-mob-{{ $booking->id }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="document.getElementById('status-form-mob-{{ $booking->id }}').submit()" 
                                    class="text-[10px] font-bold rounded-full px-2 py-1 border-0 cursor-pointer focus:ring-1 focus:ring-yellow-400
                                    {{ $booking->status == 'LUNAS' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status == 'DP_DIBAYAR' ? 'bg-blue-100 text-blue-800' : 
                                       ($booking->status == 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    <option value="PENDING" {{ $booking->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                    <option value="DP_DIBAYAR" {{ $booking->status == 'DP_DIBAYAR' ? 'selected' : '' }}>DP DIBAYAR</option>
                                    <option value="LUNAS" {{ $booking->status == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                                    <option value="DIBATALKAN" {{ $booking->status == 'DIBATALKAN' ? 'selected' : '' }}>DIBATALKAN</option>
                                </select>
                            </form>
                            <div class="mt-2 font-bold text-sm text-gray-900">Rp {{ number_format($booking->price_total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-2 border-t border-gray-50" @click.stop>
                        <div class="flex gap-3">
                            @if($booking->payment_proof)
                                <button @click="openImageModal('{{ asset('storage/' . $booking->payment_proof) }}')" class="text-blue-500 text-xs flex items-center gap-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Bukti TF
                                </button>
                            @endif
                            <button @click="openDetail({{ $booking }})" class="text-gray-600 text-xs flex items-center gap-1 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Detail
                            </button>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" class="text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </a>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">Belum ada data booking.</div>
                @endforelse
            </div>
        </div>
        
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>

        <!-- Image Modal -->
        <div x-show="showImageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] flex flex-col" @click.away="showImageModal = false">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-bold text-gray-900">Bukti Transfer</h3>
                    <button @click="showImageModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4 flex-1 overflow-auto flex justify-center bg-gray-100">
                    <img :src="imgSrc" alt="Bukti Transfer" class="max-w-full h-auto object-contain rounded">
                </div>
                <div class="p-4 border-t flex justify-end">
                    <a :href="imgSrc" download class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download Gambar
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-100">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full flex flex-col max-h-[90vh]" @click.away="showDetailModal = false">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-xl font-bold text-gray-900">Detail Booking</h3>
                    <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 overflow-y-auto">
                    <!-- Calendar Date Display -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-xl flex flex-col items-center justify-center border-2 border-gray-200 shadow-sm">
                            <span class="text-xs text-red-500 font-bold uppercase" x-text="formatDate(selectedBooking.event_date, 'month')"></span>
                            <span class="text-3xl font-bold text-gray-900 leading-none" x-text="formatDate(selectedBooking.event_date, 'day')"></span>
                            <span class="text-[10px] text-gray-500" x-text="formatDate(selectedBooking.event_date, 'year')"></span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900" x-text="selectedBooking.event_type || 'Acara'"></h4>
                            <p class="text-sm text-gray-900" x-text="selectedBooking.customer_name"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Paket Info -->
                        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
                            <h5 class="text-xs font-bold text-yellow-800 uppercase mb-2 tracking-wider">Detail Paket</h5>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="block text-gray-500 text-xs">Paket</span>
                                    <span class="font-bold text-gray-900" x-text="selectedBooking.package_name"></span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-xs">Durasi</span>
                                    <span class="font-bold text-gray-900"><span x-text="selectedBooking.duration_hours"></span> Jam</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-xs">Waktu</span>
                                    <span class="font-bold text-gray-900">
                                        <span x-text="formatTime(selectedBooking.event_time)"></span> - 
                                        <span x-text="calculateEndTime(selectedBooking.event_time, selectedBooking.duration_hours)"></span>
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-xs">Status</span>
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold" 
                                          :class="{
                                              'bg-green-100 text-green-800': selectedBooking.status === 'LUNAS',
                                              'bg-blue-100 text-blue-800': selectedBooking.status === 'DP_DIBAYAR',
                                              'bg-yellow-100 text-yellow-800': selectedBooking.status === 'PENDING',
                                              'bg-gray-100 text-gray-800': selectedBooking.status === 'DIBATALKAN' || !selectedBooking.status
                                          }" 
                                          x-text="selectedBooking.status || 'PENDING'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Location Info -->
                        <div>
                            <h5 class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Lokasi Acara</h5>
                            <p class="text-sm text-gray-900 mb-2" x-text="selectedBooking.event_location"></p>
                            <template x-if="selectedBooking.event_maps_link">
                                <a :href="selectedBooking.event_maps_link" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Buka di Google Maps
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Actions) -->
                <div class="p-6 border-t bg-gray-50 rounded-b-2xl grid grid-cols-2 gap-4">
                    <a :href="'https://wa.me/' + formatWhatsApp(selectedBooking.customer_phone)" target="_blank" class="flex justify-center items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                        Chat WA
                    </a>
                    <button @click="copyBookingData()" class="flex justify-center items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        Salin Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function bookingManager() {
            return {
                showImageModal: false,
                showDetailModal: false,
                imgSrc: '',
                selectedBooking: {},

                openImageModal(src) {
                    this.imgSrc = src;
                    this.showImageModal = true;
                },

                openDetail(booking) {
                    this.selectedBooking = booking;
                    this.showDetailModal = true;
                },

                formatDate(dateStr, type) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    // Use standard JS Date methods or a library if available. 
                    // Since no library is guaranteed in this context, using basic formatter.
                    const options = { timeZone: 'Asia/Makassar' };
                    
                    if (type === 'day') return date.getDate();
                    if (type === 'month') return date.toLocaleDateString('id-ID', { month: 'short' });
                    if (type === 'year') return date.getFullYear();
                    if (type === 'full') return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    return '';
                },

                formatTime(timeStr) {
                    if (!timeStr) return '';
                    // Extract HH:mm from HH:mm:ss
                    return timeStr.substring(0, 5);
                },

                calculateEndTime(startTime, duration) {
                    if (!startTime || !duration) return '';
                    const [hours, minutes] = startTime.split(':').map(Number);
                    const endDate = new Date();
                    endDate.setHours(hours + parseInt(duration));
                    endDate.setMinutes(minutes);
                    return endDate.getHours().toString().padStart(2, '0') + ':' + endDate.getMinutes().toString().padStart(2, '0');
                },

                formatWhatsApp(phone) {
                    if (!phone) return '';
                    return phone.replace(/^0/, '62').replace(/[^0-9]/g, '');
                },

                copyBookingData() {
                    const b = this.selectedBooking;
                    const eventDate = new Date(b.event_date).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                    const startTime = this.formatTime(b.event_time);
                    const endTime = this.calculateEndTime(b.event_time, b.duration_hours);
                    
                    const text = `*Detail Booking Luminara Photobooth*\n\n` +
                        `Nama: ${b.customer_name}\n` +
                        `Acara: ${b.event_type || '-'}\n` +
                        `Tanggal: ${eventDate}\n` +
                        `Waktu: ${startTime} - ${endTime} WITA\n` +
                        `Paket: ${b.package_name} (${b.duration_hours} Jam)\n` +
                        `Lokasi: ${b.event_location || '-'}\n` +
                        `Maps: ${b.event_maps_link || '-'}\n\n` +
                        `Status: ${b.status}\n` + 
                        `Total: Rp ${new Intl.NumberFormat('id-ID').format(b.price_total)}`;

                    navigator.clipboard.writeText(text).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Disalin',
                            text: 'Data booking telah disalin ke clipboard',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyalin',
                            text: 'Perizinan clipboard ditolak atau tidak didukung browser.',
                        });
                    });
                }
            }
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Booking yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
@endsection