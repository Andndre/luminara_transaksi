@props(['props' => [], 'section' => null, 'page' => null])

@php
$content = $props['content'] ?? '';
$fontFamily = $props['font_family'] ?? 'Lato';
$fontSize = $props['font_size'] ?? 16;
$fontWeight = $props['font_weight'] ?? '400';
$color = $props['color'] ?? '#333333';
$alignment = $props['alignment'] ?? 'left';
$maxWidth = $props['max_width'] ?? 800;
@endphp

<section class="text-section-{{ $section->id }} py-8">
  <div class="container mx-auto px-4">
    <div class="text-{{ $alignment }}" style="max-width: {{ $maxWidth }}px; margin: 0 auto;">
      <div class="text-content"
           style="font-family: {{ $fontFamily }}, sans-serif; font-size: {{ $fontSize }}px; font-weight: {{ $fontWeight }}; color: {{ $color }};">
        {!! nl2br(e($content)) !!}
      </div>
    </div>
  </div>
</section>
