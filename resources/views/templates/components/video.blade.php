@props(['props' => [], 'section' => null, 'page' => null])

@php
$videoType = $props['type'] ?? 'upload';
$src = $props['src'] ?? '';
$youtubeUrl = $props['youtube_url'] ?? '';
$autoplay = $props['autoplay'] ?? false;
$muted = $props['muted'] ?? true;
$controls = $props['controls'] ?? true;
$width = $props['width'] ?? 100;
$marginTop = $props['margin_top'] ?? 0;
$marginBottom = $props['margin_bottom'] ?? 24;
@endphp

@php
$youtubeVideoId = null;
if($videoType === 'youtube' && $youtubeUrl) {
  if(preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $youtubeUrl, $matches)) {
    $youtubeVideoId = $matches[1];
  }
}
@endphp

<section class="video-section-{{ $section->id }}" style="margin-top: {{ $marginTop }}px; margin-bottom: {{ $marginBottom }}px;">
  <div class="container mx-auto px-4">
    <div class="flex justify-center">
      <div style="width: {{ $width }}%;">

        @if($videoType === 'youtube' && $youtubeVideoId)
          <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0;">
            <iframe src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?autoplay={{ $autoplay ? '1' : '0' }}&mute={{ $muted ? '1' : '0' }}&controls={{ $controls ? '1' : '0' }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 8px;">
            </iframe>
          </div>
        @elseif($src)
          <video src="{{ '/storage/' . $src }}"
                 @if($autoplay) autoplay @endif
                 @if($muted) muted @endif
                 @if($controls) controls @endif
                 style="width: 100%; border-radius: 8px;"
                 playsinline>
            Your browser does not support the video tag.
          </video>
        @endif

      </div>
    </div>
  </div>
</section>
