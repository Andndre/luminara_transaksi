@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Paket</h1>
            <p class="text-gray-500">Atur paket layanan dan daftar harga.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded-lg transition">
            + Tambah Paket
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @foreach($packages as $package)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-xl font-bold text-gray-900">{{ $package->name }}</h3>
                        <span class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-500">{{ $package->type }}</span>
                        @if(!$package->is_active)
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-bold">Non-Aktif</span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm">{{ $package->description }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.packages.edit', $package->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                    </form>
                </div>
            </div>
            <div class="p-6 bg-gray-50">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Daftar Harga</h4>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                    @foreach($package->prices->sortBy('duration_hours') as $price)
                        <div class="bg-white p-2 rounded border border-gray-200 text-center">
                            <span class="block text-[10px] md:text-xs text-gray-500">{{ $price->duration_hours }} Jam</span>
                            <span class="block font-bold text-gray-900 text-xs md:text-sm">Rp {{ number_format($price->price/1000, 0) }}k</span>
                            @if($price->description)
                                <span class="block text-[10px] text-gray-400 truncate">{{ $price->description }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
