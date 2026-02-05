<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Editor - Luminara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Test Component Rendering</h1>

        <!-- Test Hero Component -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Hero Section Test</h2>
            <div class="relative bg-cover bg-center py-32 text-center text-white"
                 style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1200');">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="relative z-10">
                    <p class="text-xl mb-2">The Wedding Of</p>
                    <h1 class="text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">Romeo & Juliet</h1>
                    <p class="text-xl">25 Desember 2025</p>
                </div>
            </div>
        </div>

        <!-- Test Text Component -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Text Block Test</h2>
            <div class="py-12 text-center">
                <p class="text-gray-700 leading-relaxed">
                    Kami mengundang Anda untuk hadir di pernikahan kami. Merupakan suatu kehormatan
                    dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan
                    doa restu kepada kami.
                </p>
            </div>
        </div>

        <!-- Test Countdown Component -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Countdown Test</h2>
            <div class="py-16 bg-gray-900 text-white text-center">
                <h3 class="text-2xl mb-8">Counting Down To Our Special Day</h3>
                <div class="flex justify-center gap-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-400" id="days">00</div>
                        <div class="text-sm mt-2">Hari</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-400" id="hours">00</div>
                        <div class="text-sm mt-2">Jam</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-400" id="minutes">00</div>
                        <div class="text-sm mt-2">Menit</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-400" id="seconds">00</div>
                        <div class="text-sm mt-2">Detik</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test RSVP Component -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">RSVP Form Test</h2>
            <div class="py-12 bg-gray-50">
                <form class="max-w-md mx-auto">
                    <h3 class="text-2xl font-bold text-center mb-2">RSVP</h3>
                    <p class="text-center text-gray-600 mb-6">Please confirm your attendance</p>
                    <div class="space-y-4">
                        <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 border rounded-lg">
                        <input type="tel" placeholder="No. WhatsApp" class="w-full px-4 py-3 border rounded-lg">
                        <select class="w-full px-4 py-3 border rounded-lg">
                            <option>Hadir</option>
                            <option>Tidak Hadir</option>
                            <option>Ragu-ragu</option>
                        </select>
                        <textarea placeholder="Pesan/Ucapan" rows="3" class="w-full px-4 py-3 border rounded-lg"></textarea>
                        <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800">
                            Kirim Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple countdown test
        const targetDate = new Date('2025-12-25').getTime();

        setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = days;
                document.getElementById('hours').textContent = hours;
                document.getElementById('minutes').textContent = minutes;
                document.getElementById('seconds').textContent = seconds;
            }
        }, 1000);
    </script>
</body>
</html>
