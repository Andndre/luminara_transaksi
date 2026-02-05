@extends('layouts.admin')

@section('title', 'Edit Template')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.templates.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">Edit Template</h1>
    </div>

    <form action="{{ route('admin.templates.update', $template->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Template *</label>
                <input type="text" name="name" value="{{ old('name', $template->name) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $template->slug) }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    <option value="rustic" {{ old('category', $template->category) === 'rustic' ? 'selected' : '' }}>Rustic</option>
                    <option value="modern" {{ old('category', $template->category) === 'modern' ? 'selected' : '' }}>Modern</option>
                    <option value="elegant" {{ old('category', $template->category) === 'elegant' ? 'selected' : '' }}>Elegant</option>
                    <option value="minimalist" {{ old('category', $template->category) === 'minimalist' ? 'selected' : '' }}>Minimalist</option>
                    <option value="floral" {{ old('category', $template->category) === 'floral' ? 'selected' : '' }}>Floral</option>
                    <option value="vintage" {{ old('category', $template->category) === 'vintage' ? 'selected' : '' }}>Vintage</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                <input type="text" name="thumbnail" value="{{ old('thumbnail', $template->thumbnail) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">{{ old('description', $template->description) }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $template->is_active) ? 'checked' : '' }} class="w-4 h-4 text-yellow-500 rounded focus:ring-yellow-500">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Template Aktif</label>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.templates.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
