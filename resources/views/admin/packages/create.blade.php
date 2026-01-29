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
                    description: ''
                },
                prices: [
                    { duration: 2, price: '', description: '' }
                ],
                presets: {
                    // PHOTOBOOTH
                    'pb_file': {
                        name: 'QR Package (File Only)', type: 'pb_file', base_price: 1000000,
                        description: 'Hanya Softcopy (QR Download). No Print.',
                        prices: [
                            {duration: 2, price: 1000000}, {duration: 3, price: 1200000}, {duration: 4, price: 1400000},
                            {duration: 5, price: 1600000}, {duration: 6, price: 1800000}, {duration: 7, price: 2000000},
                            {duration: 8, price: 2200000}, {duration: 9, price: 2400000}, {duration: 10, price: 2600000},
                            {duration: 11, price: 2800000}, {duration: 12, price: 3000000}
                        ]
                    },
                    'pb_limited': {
                        name: 'Limited Print', type: 'pb_limited', base_price: 1300000,
                        description: 'Kuota Cetak Terbatas. Termasuk: Kamera DSLR, Layar 24", Lighting, Props.',
                        prices: [
                            {duration: 2, price: 1300000, description: '50 Print'}, {duration: 3, price: 1600000, description: '80 Print'},
                            {duration: 4, price: 1800000, description: '100 Print'}, {duration: 5, price: 2500000, description: '200 Print'},
                            {duration: 6, price: 3200000, description: '300 Print'}, {duration: 7, price: 3900000, description: '400 Print'},
                            {duration: 8, price: 4400000, description: '500 Print'}, {duration: 9, price: 5000000, description: '600 Print'},
                            {duration: 10, price: 5600000, description: '700 Print'}, {duration: 11, price: 6300000, description: '800 Print'},
                            {duration: 12, price: 6500000, description: '900 Print'}
                        ]
                    },
                    'pb_unlimited': {
                        name: 'Unlimited Print', type: 'pb_unlimited', base_price: 2000000,
                        description: 'Cetak Sepuasnya. Termasuk: Kamera DSLR, Layar 24", Lighting, Props.',
                        prices: [
                            {duration: 2, price: 2000000}, {duration: 3, price: 2500000}, {duration: 4, price: 3000000},
                            {duration: 5, price: 3500000}, {duration: 6, price: 4000000}, {duration: 7, price: 4500000},
                            {duration: 8, price: 5000000}, {duration: 9, price: 5500000}, {duration: 10, price: 6000000},
                            {duration: 11, price: 6500000}, {duration: 12, price: 7000000}
                        ]
                    },
                    // VIDEO & COMBO
                    'videobooth360': {
                        name: 'Videobooth 360 Unlimited', type: 'videobooth360', base_price: 2000000,
                        description: 'Unlimited Video, Slowmo/Rewind, Custom Overlay.',
                        prices: [
                            {duration: 2, price: 2000000}, {duration: 3, price: 2500000}, {duration: 4, price: 3000000},
                            {duration: 5, price: 3500000}, {duration: 6, price: 4000000}, {duration: 7, price: 4500000},
                            {duration: 8, price: 5000000}
                        ]
                    },
                    'combo_file': {
                        name: 'Combo Photobooth (File) + 360', type: 'combo_file', base_price: 2800000,
                        description: 'Unlimited Photobooth (File Only) & Video 360.',
                        prices: [
                            {duration: 2, price: 2800000}, {duration: 3, price: 3500000}, {duration: 4, price: 4200000},
                            {duration: 5, price: 4900000}, {duration: 6, price: 5600000}, {duration: 7, price: 6300000},
                            {duration: 8, price: 7000000}, {duration: 9, price: 7700000}, {duration: 10, price: 8400000}
                        ]
                    },
                    'combo_unlimited': {
                        name: 'Combo Photobooth (Print) + 360', type: 'combo_unlimited', base_price: 3950000,
                        description: 'Unlimited Print & Video 360. BEST VALUE.',
                        prices: [
                            {duration: 2, price: 3950000}, {duration: 3, price: 4900000}, {duration: 4, price: 5850000},
                            {duration: 5, price: 6800000}, {duration: 6, price: 7750000}, {duration: 7, price: 8700000},
                            {duration: 8, price: 9650000}, {duration: 9, price: 10600000}, {duration: 10, price: 11500000}
                        ]
                    },
                    // VISUAL
                    'visual_basic': {
                        name: 'Visual: Paket Basic Foto Only', type: 'visual_basic', base_price: 1300000,
                        description: '8 jam kerja. 50-60 foto edit. Google Drive.',
                        prices: [{duration: 8, price: 1300000}]
                    },
                    'visual_standar': {
                        name: 'Visual: Paket Standar Foto & Video', type: 'visual_standar', base_price: 3000000,
                        description: '8 jam kerja. 70-80 foto edit. Video highlight 3-5 menit.',
                        prices: [{duration: 8, price: 3000000}]
                    },
                    'grad_1': {
                        name: 'Graduation: Paket 1', type: 'grad_1', base_price: 250000,
                        description: '1 Wisudawan/Wati. 30 Menit. 30 File Edit.',
                        prices: [{duration: 1, price: 250000, description: '30 Menit'}]
                    },
                    'grad_2': {
                        name: 'Graduation: Paket 2', type: 'grad_2', base_price: 400000,
                        description: '1 Wisudawan/Wati. 60 Menit. 80 File Edit.',
                        prices: [{duration: 1, price: 400000, description: '60 Menit'}]
                    },
                    'grad_3': {
                        name: 'Graduation: Paket 3', type: 'grad_3', base_price: 700000,
                        description: '1 Wisudawan/Wati. 60 Menit. 40 Foto Edit + 1 Menit Video.',
                        prices: [{duration: 1, price: 700000, description: '60 Menit'}]
                    }
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
                        // Clone array to avoid reference issues
                        this.prices = JSON.parse(JSON.stringify(p.prices));
                    }
                }
            }
        }
    </script>
@endsection
