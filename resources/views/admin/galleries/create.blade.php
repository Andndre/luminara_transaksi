@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm text-sm font-medium transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Galeri
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Upload Foto Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-8 space-y-6">
            @csrf
            
            @if(auth()->user()->division == 'super_admin')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Divisi</label>
                <select name="business_unit" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">
                    <option value="photobooth">Photobooth</option>
                    <option value="visual">Visual (Dokumentasi)</option>
                </select>
            </div>
            @endif

            <div x-data="{ imagePreview: null }">
                <label class="block text-sm font-medium text-gray-700 mb-1">File Foto</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-yellow-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required 
                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result }; reader.readAsDataURL(file); }">
                
                <template x-if="imagePreview">
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-2">Preview:</p>
                        <img :src="imagePreview" class="max-w-xs h-auto rounded-lg shadow-md border border-gray-200">
                    </div>
                </template>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WebP. Maksimal 5MB.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul / Caption (Opsional)</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" placeholder="Contoh: Wedding A & B">
            </div>

            <div class="flex items-center gap-3 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                <input type="checkbox" name="is_featured" id="is_featured" class="w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500">
                <div>
                    <label for="is_featured" class="block text-sm font-bold text-gray-900">Jadikan Foto Terbaik (Featured)</label>
                    <p class="text-xs text-gray-600">Foto ini akan tampil sebagai background slideshow di Landing Page utama.</p>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-black text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-gray-800 transition">
                    Upload Foto
                </button>
            </div>
        </form>
    </div>
@endsection
