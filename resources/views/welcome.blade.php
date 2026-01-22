<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminara Photobooth | Abadikan Momen Seru Kamu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm fixed w-full z-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <span class="font-bold text-2xl text-indigo-600">Luminara<span class="text-gray-800">Photobooth</span></span>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="#services" class="hover:text-indigo-600 transition">Layanan</a>
                    <a href="#gallery" class="hover:text-indigo-600 transition">Galeri</a>
                    <a href="#contact" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 bg-indigo-50">
        <div class="max-w-6xl mx-auto px-4 flex flex-col-reverse md:flex-row items-center">
            <div class="md:w-1/2 mt-10 md:mt-0 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                    Bikin Acaramu Makin Seru dengan <span class="text-indigo-600">Photobooth Kekinian!</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Layanan Photobooth eksklusif di Bali untuk Wedding, Birthday, Gathering, dan Event Kampus. Cetak instan, kenangan selamanya.
                </p>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="https://wa.me/6287788986136?text=Halo%20Luminara%20Photobooth,%20saya%20ingin%20tanya%20pricelist"
                       class="px-8 py-3 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-1">
                       Booking Sekarang
                    </a>
                    <a href="#gallery" class="px-8 py-3 bg-white text-indigo-600 border border-indigo-200 rounded-lg hover:bg-gray-50 transition">
                        Lihat Contoh
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="w-full max-w-md bg-gray-200 h-80 rounded-2xl shadow-xl flex items-center justify-center text-gray-400">
                    [Area Foto Setup Photobooth / Hasil Foto Strip]
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pilihan Paket Spesial</h2>
                <p class="text-gray-600">Pilih paket terbaik untuk meriahkan acaramu</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden border border-indigo-100 flex flex-col relative">
                    <div class="bg-indigo-600 py-2 text-center text-white text-sm font-bold uppercase tracking-wide">Most Popular</div>
                    <div class="p-8 flex-grow">
                        <h3 class="text-2xl font-bold mb-2">Unlimited Print</h3>
                        <p class="text-gray-500 mb-6">Cetak sepuasnya tanpa batas!</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900">Rp 2.000k</span>
                            <span class="text-gray-500">/ 2 Jam</span>
                        </div>
                        <div class="space-y-2 mb-6 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between"><span>3 Jam</span> <span class="font-semibold">Rp 2.500.000</span></div>
                            <div class="flex justify-between"><span>4 Jam</span> <span class="font-semibold">Rp 3.000.000</span></div>
                            <div class="flex justify-between"><span>Extra Hour</span> <span class="font-semibold">+ Rp 700rb/jam</span></div>
                        </div>
                        <ul class="space-y-3 mb-8 text-gray-600 text-sm">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Unlimited 4R Print</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Free Custom Design Template</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Fun Props & Accessories</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Free Softcopy via QR Code</li>
                        </ul>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        <a href="#booking" onclick="selectPackage('Unlimited Print')" class="block w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg text-center hover:bg-indigo-700 transition">Pilih Paket Ini</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden border border-gray-100 flex flex-col">
                    <div class="p-8 flex-grow">
                        <h3 class="text-2xl font-bold mb-2">VideoBooth 360°</h3>
                        <p class="text-gray-500 mb-6">Video slowmo kekinian & viral</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900">Rp 2.000k</span>
                            <span class="text-gray-500">/ 2 Jam</span>
                        </div>
                        <div class="space-y-2 mb-6 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between"><span>3 Jam</span> <span class="font-semibold">Rp 2.500.000</span></div>
                            <div class="flex justify-between"><span>4 Jam</span> <span class="font-semibold">Rp 3.000.000</span></div>
                            <div class="flex justify-between"><span>Extra Hour</span> <span class="font-semibold">+ Rp 600rb/jam</span></div>
                        </div>
                        <ul class="space-y-3 mb-8 text-gray-600 text-sm">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> High Quality 360 Video</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Instant Share QR Code</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Slowmo & Rewind Effect</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Custom Overlay Design</li>
                        </ul>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        <a href="#booking" onclick="selectPackage('VideoBooth 360')" class="block w-full py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg text-center hover:bg-indigo-50 transition">Pilih Paket Ini</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden border border-purple-100 flex flex-col relative">
                     <div class="bg-purple-600 py-2 text-center text-white text-sm font-bold uppercase tracking-wide">Best Value</div>
                    <div class="p-8 flex-grow">
                        <h3 class="text-2xl font-bold mb-2">Combo Package</h3>
                        <p class="text-gray-500 mb-6">Photobooth + VideoBooth 360</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900">Rp 3.950k</span>
                            <span class="text-gray-500">/ 2 Jam</span>
                        </div>
                         <div class="space-y-2 mb-6 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between"><span>3 Jam</span> <span class="font-semibold">Rp 4.900.000</span></div>
                            <div class="flex justify-between"><span>4 Jam</span> <span class="font-semibold">Rp 5.850.000</span></div>
                        </div>
                        <ul class="space-y-3 mb-8 text-gray-600 text-sm">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <b>Double Station</b> (Photo & Video)</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Unlimited Print 4R</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Unlimited 360 Video</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Hemat hingga Rp 1 Juta!</li>
                        </ul>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        <a href="#booking" onclick="selectPackage('Combo Package')" class="block w-full py-3 bg-purple-600 text-white font-semibold rounded-lg text-center hover:bg-purple-700 transition">Ambil Promo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="py-20 bg-white border-t border-gray-100">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Formulir Pemesanan</h2>
                <p class="text-gray-600">Amankan tanggal acaramu sekarang. Isi form di bawah ini!</p>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" class="bg-white md:p-8 rounded-2xl shadow-none md:shadow-lg border border-gray-100">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            placeholder="Contoh: Ida Bagus Yudhi">
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                        <input type="number" name="whatsapp" id="whatsapp" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            placeholder="08xxxxxxxxx">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nama_acara" class="block text-sm font-medium text-gray-700 mb-2">Nama Acara</label>
                        <input type="text" name="nama_acara" id="nama_acara" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                            placeholder="Contoh: Wedding of Arta & Cahyani">
                    </div>

                    <div>
                        <label for="tanggal_acara" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" id="tanggal_acara" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="jam_sesi" class="block text-sm font-medium text-gray-700 mb-2">Jam Sesi Photobooth / Mulai Acara</label>
                    <input type="time" name="jam_sesi" id="jam_sesi" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition">
                    <p class="text-xs text-gray-500 mt-1">*Tim kami akan standby 1 jam sebelum sesi dimulai.</p>
                </div>

                <div class="mb-6">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap & Lokasi Acara</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition"
                        placeholder="Nama Gedung/Hotel, Jalan, Kota..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="paket" class="block text-sm font-medium text-gray-700 mb-2">Pilihan Paket</label>
                        <select name="paket" id="paket" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition">
                            <option value="Unlimited Print">Photobooth Unlimited Print</option>
                            <option value="VideoBooth 360">VideoBooth 360</option>
                            <option value="Combo Package">Combo (Photo + Video)</option>
                            <option value="QR Only">QR Package (File Only)</option>
                            <option value="Limited Print">Limited Print Package</option>
                        </select>
                    </div>

                    <div>
                        <label for="durasi" class="block text-sm font-medium text-gray-700 mb-2">Pilihan Waktu (Durasi)</label>
                        <select name="durasi" id="durasi" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition">
                            <option value="2 Jam">2 Jam</option>
                            <option value="3 Jam">3 Jam</option>
                            <option value="4 Jam">4 Jam</option>
                            <option value="5 Jam">5 Jam</option>
                            <option value="6 Jam">6 Jam</option>
                            <option value="Full Day">Lebih dari 6 Jam</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-lg shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-1">
                    Kirim Pesanan Saya
                </button>
                <p class="text-center text-sm text-gray-500 mt-4">
                    Data kamu akan aman. Admin kami akan segera menghubungi via WhatsApp untuk konfirmasi invoice & DP.
                </p>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <script>
        function selectPackage(packageName) {
            const select = document.getElementById('paket');
            // Loop opsi untuk mencocokkan value
            for(let i=0; i < select.options.length; i++){
                if(select.options[i].value == packageName){
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    </script>

    <section id="services" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Kenapa Pilih Luminara Photobooth?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">High Speed Printing</h3>
                    <p class="text-gray-600">Cetak foto super cepat dalam hitungan detik agar antrean tamu tidak menumpuk.</p>
                </div>
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Custom Template</h3>
                    <p class="text-gray-600">Desain frame foto yang disesuaikan dengan tema acara kamu. Unik & Personal.</p>
                </div>
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fun Props</h3>
                    <p class="text-gray-600">Aksesoris foto yang lucu dan beragam untuk memeriahkan gaya tamu undangan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-4">Luminara Photobooth</h3>
                <p class="text-gray-400 mb-4">Bagian dari Luminara Visual. <br>Melayani seluruh area Bali.</p>
                <p class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i>Jl. Sultan Agung No 9X, Karangasem, Bali 80811</p>
            </div>
            <div class="md:text-right">
                <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                <p class="mb-2"><a href="mailto:luminara.visual.bali@gmail.com" class="hover:text-indigo-400 transition">luminara.visual.bali@gmail.com</a></p>
                <p class="mb-4 text-xl font-bold text-indigo-400">0877-8898-6136</p>
                <div class="flex md:justify-end space-x-4">
                    <a href="https://instagram.com/luminara_photobooth" class="text-gray-400 hover:text-white transition">Instagram</a>
                    </div>
            </div>
        </div>
        <div class="text-center mt-12 border-t border-gray-800 pt-8 text-sm text-gray-500">
            &copy; {{ date('Y') }} Luminara Photobooth. All rights reserved.
        </div>
    </footer>

</body>
</html>
