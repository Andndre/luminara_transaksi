<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminara Photobooth - Abadikan Momen Berharga Selamanya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luminara: {
                            gold: '#D4AF37',
                            dark: '#0f0f0f',
                            light: '#f8f9fa',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background-image: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        #navbar {
            transition: all 0.3s ease;
        }

        .nav-transparent {
            background-color: transparent;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .nav-transparent .nav-item {
            color: white;
        }
        .nav-transparent .nav-item:hover {
            color: #D4AF37;
        }
        .nav-transparent .nav-btn {
            background-color: white;
            color: black;
        }

        .nav-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .nav-scrolled .nav-item {
            color: #1a1a1a;
        }
        .nav-scrolled .nav-item:hover {
            color: #D4AF37;
        }
        .nav-scrolled .nav-btn {
            background-color: black;
            color: white;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased selection:bg-luminara-gold selection:text-white">

    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 nav-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="/images/logo.png" alt="Luminara Logo" class="h-10 w-auto drop-shadow-md">
                    <span class="font-serif text-2xl font-bold tracking-wide nav-item transition-colors duration-300">Luminara</span>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-sm font-medium tracking-wide nav-item transition-colors duration-300">BERANDA</a>
                    <a href="#features" class="text-sm font-medium tracking-wide nav-item transition-colors duration-300">KEUNGGULAN</a>
                    <a href="#pricing" class="text-sm font-medium tracking-wide nav-item transition-colors duration-300">HARGA</a>
                    <a href="{{ route('booking.create') }}" class="px-6 py-2 rounded-full text-sm font-bold tracking-wide transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg nav-btn uppercase">
                        Booking Sekarang
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button class="nav-item focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-bg h-screen flex items-center justify-center text-center px-4 relative">
        <div class="max-w-5xl mx-auto text-white z-10 opacity-0" style="animation: fadeInUp 1s ease-out forwards;">
            <p class="text-luminara-gold font-serif text-xl md:text-2xl italic mb-4 tracking-wider">Pengalaman Event Premium</p>
            <h1 class="font-serif text-5xl md:text-8xl font-bold mb-8 leading-tight tracking-tight drop-shadow-lg">
                Abadikan Momen <br> <span class="text-white">Berharga</span>
            </h1>
            <p class="text-lg md:text-xl mb-12 text-gray-200 font-light max-w-2xl mx-auto leading-relaxed drop-shadow-md">
                Layanan Photobooth & 360° Videobooth terbaik di Bali. <br>Tangkap setiap senyuman, setiap gerakan, setiap momen.
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center">
                <a href="{{ route('booking.create') }}" class="group bg-luminara-gold text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-black transition-all duration-300 shadow-[0_0_20px_rgba(212,175,55,0.4)] hover:shadow-[0_0_30px_rgba(255,255,255,0.6)]">
                    Pesan Tanggal
                    <span class="inline-block ml-2 transition-transform group-hover:translate-x-1">&rarr;</span>
                </a>
                <a href="#pricing" class="bg-white/10 backdrop-blur-sm border border-white/30 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-white/20 transition duration-300">
                    Lihat Paket
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#features" class="text-white/70 hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path></svg>
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="font-serif text-4xl font-bold mb-4">Standar Luminara</h2>
                <div class="w-24 h-1 bg-luminara-gold mx-auto"></div>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Kami menggunakan peralatan profesional untuk memastikan kualitas visual terbaik untuk acara Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition text-center group border border-transparent hover:border-gray-200">
                    <div class="w-14 h-14 bg-gray-900 text-luminara-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Canon DSLR Pro</h3>
                    <p class="text-sm text-gray-500">Kualitas foto tajam dengan kamera DSLR profesional, bukan webcam.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition text-center group border border-transparent hover:border-gray-200">
                    <div class="w-14 h-14 bg-gray-900 text-luminara-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Layar Live View 22"</h3>
                    <p class="text-sm text-gray-500">Monitoring real-time dengan layar besar agar gaya lebih maksimal.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition text-center group border border-transparent hover:border-gray-200">
                    <div class="w-14 h-14 bg-gray-900 text-luminara-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Pencahayaan Studio</h3>
                    <p class="text-sm text-gray-500">Flash Studio 300 Watt + Light 50 Watt untuk hasil sempurna.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-lg transition text-center group border border-transparent hover:border-gray-200">
                    <div class="w-14 h-14 bg-gray-900 text-luminara-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Gratis QR Code</h3>
                    <p class="text-sm text-gray-500">Unduh softcopy foto & video secara instan via scan QR Code.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl font-bold mb-4">Paket Terbaik Kami</h2>
                <div class="w-24 h-1 bg-luminara-gold mx-auto"></div>
                <p class="mt-4 text-gray-600">Pilihan paket favorit untuk durasi 2 Jam (Bisa ditambah)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition duration-300">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Photobooth Unlimited</h3>
                        <p class="text-sm text-gray-500 mb-6 uppercase tracking-wide">Paket Cetak Sepuasnya</p>
                        <div class="flex items-baseline mb-6">
                            <span class="text-4xl font-extrabold tracking-tight">Rp 2.000k</span>
                            <span class="ml-1 text-xl text-gray-500">/ 2 jam</span>
                        </div>
                        <ul class="space-y-4 mb-8 text-left text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><b>Cetak Unlimited</b> 4R / Strip</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Gratis Desain Template Custom
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Gratis Fun Props / Aksesoris
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Gratis Transport (Seluruh Bali*)
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Kru Profesional
                            </li>
                        </ul>
                    </div>
                    <div class="p-8 bg-gray-50 mt-auto">
                        <a href="{{ route('booking.create') }}?paket=Unlimited Photobooth&type=photobooth" class="block w-full bg-gray-900 text-white text-center py-3 rounded-xl font-semibold hover:bg-gray-800 transition">Pilih Paket Ini</a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-luminara-gold relative flex flex-col h-full transform md:-translate-y-4 z-10">
                    <div class="absolute top-0 right-0 bg-luminara-gold text-white text-xs font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wider">Best Value</div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Combo Ultimate</h3>
                        <p class="text-sm text-gray-500 mb-6 uppercase tracking-wide">Photobooth + 360 Video</p>
                        <div class="flex flex-col mb-6">
                            <span class="text-lg text-gray-400 line-through">Rp 4.000.000</span>
                            <div class="flex items-baseline">
                                <span class="text-4xl font-extrabold tracking-tight text-gray-900">Rp 3.950k</span>
                                <span class="ml-1 text-xl text-gray-500">/ 2 jam</span>
                            </div>
                        </div>
                        <ul class="space-y-4 mb-8 text-left text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-luminara-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <b>Cetak Unlimited</b> Foto
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-luminara-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <b>Video 360° Unlimited</b>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-luminara-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Berbagi Instan (AirDrop/QR)
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-luminara-gold mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Custom Overlay & Musik
                            </li>
                        </ul>
                    </div>
                    <div class="p-8 bg-gray-50 mt-auto">
                        <a href="{{ route('booking.create') }}?paket=Combo Ultimate&type=combo" class="block w-full bg-luminara-gold text-white text-center py-3 rounded-xl font-semibold hover:bg-yellow-600 transition">Pilih Paket Sultan</a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 flex flex-col h-full hover:-translate-y-1 transition duration-300">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Videobooth 360°</h3>
                        <p class="text-sm text-gray-500 mb-6 uppercase tracking-wide">Paket Video Unlimited</p>
                        <div class="flex items-baseline mb-6">
                            <span class="text-4xl font-extrabold tracking-tight">Rp 2.000k</span>
                            <span class="ml-1 text-xl text-gray-500">/ 2 jam</span>
                        </div>
                        <ul class="space-y-4 mb-8 text-left text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <b>Video Unlimited</b> Slowmo/Rewind
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Kapasitas 4-5 Orang (100cm)
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Gratis Watermark/Overlay Custom
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Kru & Pencahayaan Standby
                            </li>
                        </ul>
                    </div>
                    <div class="p-8 bg-gray-50 mt-auto">
                        <a href="{{ route('booking.create') }}?paket=Videobooth 360&type=videobooth360" class="block w-full bg-gray-900 text-white text-center py-3 rounded-xl font-semibold hover:bg-gray-800 transition">Pilih Paket Ini</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gray-900 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1533174072545-e8d4aa97edf9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')] bg-cover bg-center"></div>
        <div class="relative max-w-3xl mx-auto px-4">
            <h2 class="font-serif text-3xl md:text-5xl font-bold mb-6">Siap Membuat Acara Anda Berkesan?</h2>
            <p class="text-xl text-gray-300 mb-8">Amankan tanggal Anda sekarang sebelum slot penuh. Maksimal 4 acara per hari.</p>
            <a href="{{ route('booking.create') }}" class="inline-block bg-luminara-gold text-white text-lg font-bold px-10 py-4 rounded-full shadow-lg hover:bg-yellow-600 transition transform hover:-translate-y-1">
                Cek Ketersediaan Tanggal
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 pt-16 pb-8 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="/images/logo.png" alt="Luminara" class="h-8">
                        <span class="font-serif text-xl font-bold">Luminara</span>
                    </div>
                    <p class="text-gray-500">
                        Penyedia layanan Photobooth dan 360 Videobooth profesional di Bali untuk berbagai kebutuhan acara Anda.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-500 text-sm">
                        <li>WhatsApp: <a href="https://wa.me/6287788986136" class="hover:text-luminara-gold">0877-8898-6136</a></li>
                        <li>Instagram: <a href="https://instagram.com/luminara_photobooth" class="hover:text-luminara-gold">@luminara_photobooth</a></li>
                        <li>Instagram: <a href="https://instagram.com/luminara_visual" class="hover:text-luminara-gold">@luminara_visual</a></li>
                        <li>Lokasi: Denpasar, Bali</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Tautan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('booking.create') }}" class="text-gray-500 hover:text-luminara-gold">Formulir Booking</a></li>
                        <li><a href="#pricing" class="text-gray-500 hover:text-luminara-gold">Daftar Harga</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} Luminara Photobooth. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.remove('nav-transparent');
                navbar.classList.add('nav-scrolled');
            } else {
                navbar.classList.add('nav-transparent');
                navbar.classList.remove('nav-scrolled');
            }
        });
    </script>
</body>
</html>
