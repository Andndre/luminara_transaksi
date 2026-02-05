@props(['props' => [], 'section' => null, 'page' => null])

@php
$address = $props['address'] ?? '';
$latitude = $props['latitude'] ?? '';
$longitude = $props['longitude'] ?? '';
$zoom = $props['zoom'] ?? 15;
$height = $props['height'] ?? 400;
$showButton = $props['show_button'] ?? true;
@endphp

<section class="map-section py-12" style="background: {{ $props['background_color'] ?? '#f8f9fa' }};">
    <div class="container mx-auto px-4">
        @if($props['title'] ?? false)
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8" style="color: {{ $props['title_color'] ?? '#333333' }};">
                {{ $props['title'] }}
            </h2>
        @endif

        <div class="max-w-4xl mx-auto">
            <!-- Google Maps Embed -->
            <div class="rounded-lg overflow-hidden shadow-lg" style="height: {{ $height }}px;">
                <iframe
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&z={{ $zoom }}&output=embed">
                </iframe>
            </div>

            <!-- Address -->
            @if($address)
                <div class="mt-6 text-center">
                    <p class="text-gray-700">{{ $address }}</p>
                </div>
            @endif

            <!-- Directions Button -->
            @if($showButton)
                <div class="mt-6 text-center">
                    <a
                        href="https://www.google.com/maps/dir/?api=1&destination={{ $latitude }},{{ $longitude }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        {{ $props['button_text'] ?? 'Petunjuk Arah' }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
