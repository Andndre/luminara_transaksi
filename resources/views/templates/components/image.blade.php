@props(['props' => [], 'section' => null, 'page' => null])

@php
$src = $props['src'] ?? '';
$alt = $props['alt'] ?? '';
$width = $props['width'] ?? 100;
$borderRadius = $props['border_radius'] ?? 0;
$shadow = $props['shadow'] ?? false;
$alignment = $props['alignment'] ?? 'center';
$marginTop = $props['margin_top'] ?? 0;
$marginBottom = $props['margin_bottom'] ?? 24;
@endphp

<section class="image-section-{{ $section->id }}" style="margin-top: {{ $marginTop }}px; margin-bottom: {{ $marginBottom }}px;">
  <div class="container mx-auto px-4">
    <div class="text-{{ $alignment }}">
      <img src="{{ $src ? '/storage/' . $src : '' }}"
           alt="{{ $alt }}"
           style="width: {{ $width }}%; border-radius: {{ $borderRadius }}px; {{ $shadow ? 'box-shadow: 0 10px 25px rgba(0,0,0,0.15);' : '' }}"
           class="inline-block"
           loading="lazy">
    </div>
  </div>
</section>
