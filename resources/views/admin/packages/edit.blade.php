@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm text-sm font-medium transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Edit Paket</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" class="p-8 space-y-6" x-data="packageForm()">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                    <input type="text" name="name" value="{{ old('name', $package->name) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Tipe (Unique)</label>
                    <input type="text" name="type" value="{{ old('type', $package->type) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 font-mono text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (2 Jam)</label>
                    <input type="number" name="base_price" value="{{ old('base_price', $package->base_price) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" class="w-5 h-5 text-yellow-500 rounded focus:ring-yellow-500" {{ $package->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktifkan Paket Ini</label>
                </div>
            </div>

            <div class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Harga per Durasi</h3>
                    <button type="button" @click="addPrice()" class="text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded font-medium text-gray-700 transition">
                        + Tambah Durasi
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(price, index) in prices" :key="index">
                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="w-24">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Jam</label>
                                <input type="number" :name="`prices[${index}][duration]`" x-model="price.duration" class="w-full px-3 py-2 border rounded text-sm" required>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Harga (Rp)</label>
                                <input type="number" :name="`prices[${index}][price]`" x-model="price.price" class="w-full px-3 py-2 border rounded text-sm" required>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Info Tambahan (Opsional)</label>
                                <input type="text" :name="`prices[${index}][description]`" x-model="price.description" class="w-full px-3 py-2 border rounded text-sm">
                            </div>
                            <button type="button" @click="removePrice(index)" class="mt-6 text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition" title="Hapus Baris">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <div class="pt-6 border-t flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-8 rounded-xl shadow-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        function packageForm() {
            return {
                prices: {!! json_encode($package->prices->map(fn($p) => ['duration' => $p->duration_hours, 'price' => $p->price, 'description' => $p->description ?? ''])) !!},
                addPrice() {
                    this.prices.push({ duration: '', price: '', description: '' });
                },
                removePrice(index) {
                    this.prices = this.prices.filter((_, i) => i !== index);
                }
            }
        }
    </script>
@endsection
