    <title>Booking - Luminara Photobooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <style>
        .flatpickr-day.selected {
            background: #D4AF37 !important;
            border-color: #D4AF37 !important;
        }
        .day-marker {
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 2px;
        }
        .dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }
        .dot-red { background-color: #ef4444; }
        .dot-green { background-color: #22c55e; }
        .dot-yellow { background-color: #eab308; }
        
        .flatpickr-day.blocked {
            background-color: #fee2e2 !important;
            color: #ef4444 !important;
            text-decoration: line-through;
        }
        .flatpickr-day.full-booked {
            background-color: #fee2e2 !important;
            color: #ef4444 !important;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luminara: {
                            gold: '#D4AF37',
                            dark: '#1a1a1a',
                            light: '#f8f9fa',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="/images/logo.png" alt="Luminara Logo" class="h-10 w-auto">
                    <span class="font-serif text-2xl font-bold tracking-tight text-gray-900">Luminara</span>
                </a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-luminara-gold">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-12 lg:gap-12">
            
            <!-- Kolom Kiri: Form -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 md:p-12">
                    <h1 class="font-serif text-3xl font-bold mb-2">Formulir Pemesanan</h1>
                    <p class="text-gray-500 mb-8">Lengkapi detail acara Anda untuk mengamankan tanggal.</p>

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 font-medium">Mohon perbaiki kesalahan berikut:</p>
                                    <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" class="space-y-8">
                        @csrf
                        
                        <!-- Bagian 1: Jadwal Event -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">1. Jadwal Acara</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                                    <input type="text" name="event_date" id="event_date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold bg-white" required placeholder="Pilih tanggal..." readonly>
                                    <p class="mt-2 text-xs text-gray-500" id="date-status">Silakan pilih tanggal di kalender.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai Sesi</label>
                                    <input type="time" name="event_time" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" required>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 2: Paket -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">2. Pilih Paket</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Paket</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="package_type_select" value="photobooth" class="peer sr-only" onchange="updatePackage('Unlimited Photobooth', 'photobooth', 2000000)">
                                            <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-luminara-gold peer-checked:border-luminara-gold peer-checked:bg-yellow-50 transition text-center h-full">
                                                <div class="font-bold text-gray-900">Photobooth</div>
                                                <div class="text-sm text-gray-500">Cetak Unlimited</div>
                                                <div class="text-xs text-luminara-gold font-bold mt-1">Rp 2.000k / 2 jam</div>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="package_type_select" value="videobooth360" class="peer sr-only" onchange="updatePackage('Videobooth 360', 'videobooth360', 2000000)">
                                            <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-luminara-gold peer-checked:border-luminara-gold peer-checked:bg-yellow-50 transition text-center h-full">
                                                <div class="font-bold text-gray-900">Videobooth 360</div>
                                                <div class="text-sm text-gray-500">Video Unlimited</div>
                                                <div class="text-xs text-luminara-gold font-bold mt-1">Rp 2.000k / 2 jam</div>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="package_type_select" value="combo" class="peer sr-only" onchange="updatePackage('Combo Ultimate', 'combo', 3950000)">
                                            <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-luminara-gold peer-checked:border-luminara-gold peer-checked:bg-yellow-50 transition text-center h-full">
                                                <div class="font-bold text-gray-900">Combo Ultimate</div>
                                                <div class="text-sm text-gray-500">Foto + Video 360</div>
                                                <div class="text-xs text-luminara-gold font-bold mt-1">Rp 3.950k / 2 jam</div>
                                            </div>
                                        </label>
                                    </div>
                                    <input type="hidden" name="package_name" id="package_name">
                                    <input type="hidden" name="package_type" id="package_type">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Durasi (Jam)</label>
                                    <select name="duration_hours" id="duration_hours" onchange="calculateTotal()" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold">
                                        <option value="2">2 Jam (Default)</option>
                                        <option value="3">3 Jam</option>
                                        <option value="4">4 Jam</option>
                                        <option value="5">5 Jam</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Total</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                                        <input type="text" id="display_price" class="w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-bold text-gray-900" readonly value="0">
                                        <input type="hidden" name="price_total" id="price_total" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 3: Data Pemesan -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">3. Data Diri & Acara</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="customer_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" required placeholder="Nama Anda">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                                    <input type="tel" name="customer_phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" required placeholder="08xxxxxxxxxx">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Acara</label>
                                    <input type="text" name="event_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" required placeholder="Contoh: Pernikahan Budi & Ani">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Acara</label>
                                    <textarea name="event_location" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" required placeholder="Nama Hotel/Gedung & Alamat"></textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-luminara-gold focus:border-luminara-gold" placeholder="Request khusus atau tema acara"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-luminara-gold text-white text-lg font-bold py-4 rounded-xl shadow-lg hover:bg-yellow-600 transition transform hover:-translate-y-0.5">
                                Konfirmasi via WhatsApp
                            </button>
                            <p class="text-center text-xs text-gray-500 mt-4">
                                Pesanan akan diteruskan ke WhatsApp Admin untuk validasi jadwal dan pembayaran DP.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Info -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="bg-gray-900 text-white rounded-3xl p-8 shadow-xl mb-8">
                    <h3 class="font-serif text-2xl font-bold mb-6">Cara Memesan</h3>
                    <ul class="space-y-6">
                        <li class="flex gap-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-luminara-gold text-black rounded-full flex items-center justify-center font-bold">1</span>
                            <p class="text-sm">Isi formulir dengan detail acara Anda.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-gray-700 text-white rounded-full flex items-center justify-center font-bold">2</span>
                            <p class="text-sm">Klik tombol konfirmasi untuk mengirim pesan ke Admin.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-gray-700 text-white rounded-full flex items-center justify-center font-bold">3</span>
                            <p class="text-sm">Lakukan pembayaran DP Rp 500.000 untuk mengunci jadwal.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let basePrice = 0;
        let availabilityData = [];

        function updatePackage(name, type, price) {
            document.getElementById('package_name').value = name;
            document.getElementById('package_type').value = type;
            basePrice = price;
            calculateTotal();
        }

        function calculateTotal() {
            const duration = parseInt(document.getElementById('duration_hours').value) || 2;
            let total = 0;
            if (basePrice > 0) {
                let extraHours = duration - 2;
                let hourlyRate = 0;
                const type = document.getElementById('package_type').value;
                if (type === 'photobooth') hourlyRate = 700000;
                else if (type === 'videobooth360') hourlyRate = 900000;
                else if (type === 'combo') hourlyRate = 1200000;
                total = basePrice + (extraHours * hourlyRate);
            }
            document.getElementById('price_total').value = total;
            document.getElementById('display_price').value = new Intl.NumberFormat('id-ID').format(total);
        }

        // Initialize Flatpickr
        document.addEventListener('DOMContentLoaded', async function() {
            // Fetch Availability Data first
            try {
                // Fetch for current and next month to populate markers
                const currentMonth = new Date().toISOString().slice(0, 7);
                // Simple fetch for current month for now, ideally fetch based on calendar view change
                const response = await fetch(`/calendar/availability?month=${currentMonth}`);
                availabilityData = await response.json();
            } catch (e) {
                console.error("Failed to load availability", e);
            }

            const fp = flatpickr("#event_date", {
                locale: "id",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j F Y",
                disable: [
                    function(date) {
                        // Check if date is blocked or full
                        const dateStr = date.toISOString().slice(0, 10);
                        const data = availabilityData.find(item => item.date === dateStr);
                        if (data) {
                            return data.is_blocked || data.booking_count >= data.max_booking;
                        }
                        return false;
                    }
                ],
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const dateStr = dayElem.dateObj.toISOString().slice(0, 10);
                    const data = availabilityData.find(item => item.date === dateStr);

                    if (data) {
                        if (data.is_blocked) {
                            dayElem.classList.add("blocked");
                            dayElem.title = "Tidak Tersedia";
                        } else if (data.booking_count >= data.max_booking) {
                            dayElem.classList.add("full-booked");
                            dayElem.title = "Penuh";
                        } else if (data.booking_count > 0) {
                            // Add dots for existing bookings
                            const marker = document.createElement("div");
                            marker.className = "day-marker";
                            
                            // Show dots equal to booking count (max 3 for visual)
                            const count = Math.min(data.booking_count, 3);
                            for(let i=0; i<count; i++) {
                                const dot = document.createElement("span");
                                dot.className = "dot dot-green"; // Green for booked slots
                                marker.appendChild(dot);
                            }
                            dayElem.appendChild(marker);
                        }
                    }
                },
                onMonthChange: async function(selectedDates, dateStr, instance) {
                    // Refetch data when month changes
                    const year = instance.currentYear;
                    const month = String(instance.currentMonth + 1).padStart(2, '0');
                    try {
                        const response = await fetch(`/calendar/availability?month=${year}-${month}`);
                        availabilityData = await response.json();
                        instance.redraw();
                    } catch (e) {
                        console.error(e);
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    const statusText = document.getElementById('date-status');
                    if(selectedDates.length > 0) {
                        statusText.textContent = "Tanggal tersedia!";
                        statusText.className = "mt-2 text-xs text-green-600 font-bold";
                    } else {
                        statusText.textContent = "Silakan pilih tanggal.";
                        statusText.className = "mt-2 text-xs text-gray-500";
                    }
                }
            });

            // Auto-select package from URL
            const params = new URLSearchParams(window.location.search);
            const type = params.get('type');
            if (type) {
                const radio = document.querySelector(`input[value="${type}"]`);
                if (radio) {
                    radio.click();
                    // Scroll to form
                    document.getElementById('bookingForm').scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    </script>
</body>
</html>
