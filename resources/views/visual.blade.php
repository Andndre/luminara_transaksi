<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminara Visual - Premium Wedding & Event Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        #home {
            transition: background-image 1.5s ease-in-out;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-stone-50 text-stone-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-stone-50/80 backdrop-blur-md border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="/images/Logo Luminara Visual-BLACK-TPR.png" alt="Luminara" class="h-10">
                <span class="font-serif text-xl font-bold tracking-tight">Luminara <span class="italic font-normal">Visual</span></span>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-bold uppercase tracking-widest">
                <a href="#about" class="hover:text-amber-700 transition">About</a>
                <a href="#portfolio" class="hover:text-amber-700 transition">Portfolio</a>
                <a href="{{ route('booking.create') }}?unit=visual" class="bg-stone-900 text-white px-6 py-2.5 rounded-full hover:bg-stone-700 transition">Book Visual</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header id="home" class="pt-40 pb-20 px-4 text-center min-h-screen flex flex-col justify-center items-center relative">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-stone-50/90"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            <span class="text-amber-700 font-bold uppercase tracking-[0.4em] text-xs mb-4 block">Crafting Memories</span>
            <h1 class="text-5xl md:text-7xl font-serif mb-8 leading-tight text-stone-950">Timeless Stories Through <span class="italic font-normal underline decoration-amber-200 underline-offset-8">Cinematic</span> Lenses.</h1>
            <p class="text-stone-500 text-lg md:text-xl max-w-2xl mx-auto mb-12">Luminara Visual mengkhususkan diri dalam dokumentasi pernikahan, kelulusan, dan acara pribadi yang elegan di seluruh Bali.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#portfolio" class="px-10 py-4 bg-stone-900 text-white font-bold rounded-full hover:shadow-xl hover:-translate-y-1 transition duration-300">View Gallery</a>
                <a href="{{ route('booking.create') }}?unit=visual" class="px-10 py-4 border border-stone-900 text-stone-900 font-bold rounded-full hover:bg-stone-900 hover:text-white transition duration-300">Start Booking</a>
            </div>
        </div>
    </header>

    <!-- Placeholder Section -->
    <section id="portfolio" class="py-20 bg-stone-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="aspect-[4/5] bg-stone-200 rounded-2xl overflow-hidden relative group">
                    <div class="absolute inset-0 bg-stone-950/20 group-hover:bg-transparent transition duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-serif text-3xl mb-2">Wedding Stories</h3>
                        <p class="text-sm font-bold uppercase tracking-widest opacity-80">Bali & Beyond</p>
                    </div>
                </div>
                <div class="aspect-[4/5] bg-stone-200 rounded-2xl overflow-hidden relative group">
                    <div class="absolute inset-0 bg-stone-950/20 group-hover:bg-transparent transition duration-500"></div>
                    <img src="https://images.unsplash.com/photo-1523050853061-80e8a4ff140e?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-serif text-3xl mb-2">Graduation Sessions</h3>
                        <p class="text-sm font-bold uppercase tracking-widest opacity-80">Capture The Achievement</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-stone-200 text-center">
        <p class="text-stone-400 text-sm">© {{ date('Y') }} Luminara Visual Documentation</p>
    </footer>

    <script>
        // Hero Slideshow
        const heroImages = @json($heroImages ?? []);
        const heroBg = document.getElementById('home');
        
        // Default background
        const defaultBg = "url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=1920')";

        if (heroImages.length > 0) {
            let currentIndex = 0;
            heroBg.style.backgroundImage = `url('${heroImages[0]}')`;

            if (heroImages.length > 1) {
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % heroImages.length;
                    const nextImage = heroImages[currentIndex];
                    const img = new Image();
                    img.src = nextImage;
                    img.onload = () => {
                        heroBg.style.backgroundImage = `url('${nextImage}')`;
                    };
                }, 5000);
            }
        } else {
            heroBg.style.backgroundImage = defaultBg;
        }
    </script>
