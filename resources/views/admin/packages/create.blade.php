@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm text-sm font-medium transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Tambah Paket Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.packages.store') }}" method="POST" class="p-8 space-y-6" x-data="packageForm()">
            @csrf
            
            <!-- Preset Loader -->
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-6">
                <label class="block text-sm font-bold text-blue-800 mb-2">Isi Otomatis dari Template Pricelist</label>
                <div class="flex gap-2">
                    <select x-model="selectedPreset" @change="loadPreset()" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">-- Pilih Template Paket --</option>
                        <optgroup label="Photobooth">
                            <option value="pb_file">QR Package (File Only)</option>
                            <option value="pb_limited">Limited Print</option>
                            <option value="pb_unlimited">Unlimited Print</option>
                        </optgroup>
                        <optgroup label="Video 360 & Combo">
                            <option value="videobooth360">Videobooth 360 Unlimited</option>
                            <option value="combo_file">Combo PB (File) + 360</option>
                            <option value="combo_unlimited">Combo PB (Print) + 360</option>
                        </optgroup>
                        <optgroup label="Visual (Dokumentasi)">
                            <option value="visual_basic">Visual: Basic Foto Only (8 Jam)</option>
                            <option value="visual_standar">Visual: Standar Foto & Video (8 Jam)</option>
                            <option value="grad_1">Graduation: Paket 1 (30 Menit)</option>
                            <option value="grad_2">Graduation: Paket 2 (60 Menit)</option>
                            <option value="grad_3">Graduation: Paket 3 (Video Highlight)</option>
                        </optgroup>
                    </select>
                </div>
                <p class="text-xs text-blue-600 mt-2">* Memilih template akan menimpa data di bawah ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(Auth::user()->division == 'super_admin')
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Bisnis</label>
                    <select name="business_unit" x-model="form.business_unit" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required>
                        <option value="photobooth">Photobooth</option>
                        <option value="visual">Visual (Dokumentasi)</option>
                    </select>
                </div>
                @endif

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                    <input type="text" name="name" x-model="form.name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required placeholder="Contoh: Photobooth Unlimited">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Tipe (Unique)</label>
                    <input type="text" name="type" x-model="form.type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 font-mono text-sm" required placeholder="pb_unlimited">
                    <p class="text-xs text-gray-500 mt-1">Digunakan untuk identifikasi di sistem.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (Min Durasi)</label>
                    <input type="number" name="base_price" x-model="form.base_price" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500" required placeholder="2000000">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" x-model="form.description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500"></textarea>
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
                                <input type="text" :name="`prices[${index}][description]`" x-model="price.description" class="w-full px-3 py-2 border rounded text-sm" placeholder="Contoh: 50 Print">
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
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>

    <script>
        function packageForm() {
            return {
                selectedPreset: '',
                form: {
                    name: '',
                    type: '',
                    base_price: '',
                    description: '',
                    business_unit: 'photobooth'
                },
                prices: [
                    { duration: 2, price: '', description: '' }
                ],
                presets: {
                    // ... (keep existing presets)
                },
                addPrice() {
                    this.prices.push({ duration: '', price: '', description: '' });
                },
                removePrice(index) {
                    this.prices = this.prices.filter((_, i) => i !== index);
                },
                loadPreset() {
                    if (this.selectedPreset && this.presets[this.selectedPreset]) {
                        const p = this.presets[this.selectedPreset];
                        this.form.name = p.name;
                        this.form.type = p.type;
                        this.form.base_price = p.base_price;
                        this.form.description = p.description;
                        
                        // Auto-set business unit based on type prefix or known types
                        if (p.type.startsWith('visual') || p.type.startsWith('grad')) {
                            this.form.business_unit = 'visual';
                        } else {
                            this.form.business_unit = 'photobooth';
                        }

                        // Clone array to avoid reference issues
                        this.prices = JSON.parse(JSON.stringify(p.prices));
                    }
                }
            }
        }
    </script>
@endsection
