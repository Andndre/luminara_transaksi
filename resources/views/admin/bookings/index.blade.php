<!DOCTYPE html>
<html>
<head>
    <title>Admin Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Daftar Booking</h1>
        
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">Paket</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $booking->event_date->format('d M Y') }}</td>
                        <td class="p-4">
                            {{ $booking->customer_name }}<br>
                            <span class="text-sm text-gray-500">{{ $booking->customer_phone }}</span>
                        </td>
                        <td class="p-4">{{ $booking->package_name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $booking->status == 'LUNAS' ? 'bg-green-100 text-green-800' : 
                                   ($booking->status == 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border rounded p-1 text-sm">
                                    <option value="PENDING" {{ $booking->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                    <option value="DP_DIBAYAR" {{ $booking->status == 'DP_DIBAYAR' ? 'selected' : '' }}>DP DIBAYAR</option>
                                    <option value="LUNAS" {{ $booking->status == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                                    <option value="DIBATALKAN" {{ $booking->status == 'DIBATALKAN' ? 'selected' : '' }}>DIBATALKAN</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</body>
</html>
