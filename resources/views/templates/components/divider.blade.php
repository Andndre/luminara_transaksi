@props(['props' => [], 'section' => null, 'page' => null])

@php
$type = $props['type'] ?? 'line';
$height = $props['height'] ?? 50;
$color = $props['color'] ?? '#e5e7eb';
$lineStyle = $props['style'] ?? 'solid';
$width = $props['width'] ?? 100;
@endphp

@if($type === 'line')
  <section class="divider-section-{{ $section->id }} py-4">
    <div class="container mx-auto px-4">
      <div class="flex justify-center">
        <div style="height: {{ $height }}px; width: {{ $width }}%; border-bottom: {{ $lineStyle }} 1px {{ $color }};"></div>
      </div>
    </div>
  </section>
@else
  <section style="height: {{ $height }}px;"></section>
@endif
