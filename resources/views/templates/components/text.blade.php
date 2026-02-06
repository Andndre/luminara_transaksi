@props(['props' => [], 'section' => null, 'page' => null])

@php
$content = $props['content'] ?? 'Tulis teks anda di sini...';
$tag = $props['tag'] ?? 'p'; // h1, h2, h3, h4, h5, h6, p
$align = $props['align'] ?? 'left'; // left, center, right
@endphp

<section class="text-block-{{ $section->id ?? 'default' }}">
    @if($tag === 'h1')
        <h1 class="text-{{ $align }} text-4xl font-bold" style="font-family: 'Playfair Display', serif;">
            {!! $content !!}
        </h1>
    @elseif($tag === 'h2')
        <h2 class="text-{{ $align }} text-3xl font-bold" style="font-family: 'Playfair Display', serif;">
            {!! $content !!}
        </h2>
    @elseif($tag === 'h3')
        <h3 class="text-{{ $align }} text-2xl font-semibold" style="font-family: 'Playfair Display', serif;">
            {!! $content !!}
        </h3>
    @elseif($tag === 'h4')
        <h4 class="text-{{ $align }} text-xl font-semibold">
            {!! $content !!}
        </h4>
    @elseif($tag === 'h5')
        <h5 class="text-{{ $align }} text-lg font-medium">
            {!! $content !!}
        </h5>
    @elseif($tag === 'h6')
        <h6 class="text-{{ $align }} text-base font-medium">
            {!! $content !!}
        </h6>
    @else
        <p class="text-{{ $align }} text-base leading-relaxed">
            {!! $content !!}
        </p>
    @endif
</section>
