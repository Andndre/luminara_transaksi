@extends('layouts.admin')

@section('title', 'Templates')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Templates</h1>
            <p class="text-gray-600 mt-1">Kelola template undangan digital</p>
        </div>
        <a href="{{ route('admin.templates.create') }}" class="bg-black text-white font-semibold py-2 px-6 rounded-xl shadow-lg hover:bg-gray-800 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Template
        </a>
    </div>

    <!-- Templates Grid -->
    @if($templates->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($templates as $template)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="aspect-[3/4] bg-gray-100">
                        @if($template->thumbnail)
                            <img src="{{ Storage::url($template->thumbnail) }}" alt="{{ $template->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-100 to-yellow-200">
                                <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $template->name }}</h3>
                                @if($template->category)
                                    <p class="text-sm text-gray-500">{{ $template->category }}</p>
                                @endif
                            </div>
                            @if($template->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                            @endif
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin.templates.edit', $template->id) }}" class="flex-1 text-center px-3 py-2 border rounded-lg hover:bg-gray-50 transition text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.templates.duplicate', $template->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 border rounded-lg hover:bg-gray-50 transition text-sm">
                                    Duplicate
                                </button>
                            </form>
                            <form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus template ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada template</h3>
            <p class="text-gray-600 mb-4">Buat template undangan pertama</p>
            <a href="{{ route('admin.templates.create') }}" class="inline-block bg-black text-white font-semibold py-2 px-6 rounded-xl hover:bg-gray-800 transition">
                Buat Template
            </a>
        </div>
    @endif
</div>
@endsection
