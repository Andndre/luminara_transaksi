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
                        <span class="text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">{{ $package->business_unit }}</span>
                        <span class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-500">{{ $package->type }}</span>
                        @if(!$package->is_active)
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded font-bold">Non-Aktif</span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm">{{ $package->description }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.packages.edit', $package->id) }}" class="flex items-center gap-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 px-3 py-2 rounded-xl text-xs font-bold transition shadow-sm border border-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-1.5 bg-red-50 text-red-700 hover:bg-red-100 px-3 py-2 rounded-xl text-xs font-bold transition shadow-sm border border-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
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
