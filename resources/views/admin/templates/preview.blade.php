<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $template->name }} - Luminara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Great+Vibes&family=Lato:wght@300;400;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-100">
    <!-- Preview Banner -->
    <div class="bg-yellow-500 text-black py-2 px-4 text-center text-sm font-medium sticky top-0 z-50">
        Preview Mode - Template: {{ $template->name }}
    </div>

    <!-- Preview Content -->
    <div>
        @foreach($template->sections->sortBy('order_index') as $section)
            @if(file_exists(resource_path("views/templates/components/{$section->section_type}.blade.php")))
                @include("templates.components.{$section->section_type}", [
                    'props' => $section->props,
                    'section' => $section,
                    'page' => $template
                ])
            @else
                <div class="bg-red-100 text-red-700 p-4 text-center">
                    Component not found: {{ $section->section_type }}
                </div>
            @endif
        @endforeach
    </div>

    @foreach($template->sections->sortBy('order_index') as $section)
        @if(file_exists(resource_path("views/templates/components/{$section->section_type}.blade.php")))
            @push("scripts-{$section->id}")
                @php
                    $view = view("templates.components.{$section->section_type}", [
                        'props' => $section->props,
                        'section' => $section,
                        'page' => $template
                    ]);
                    // Extract any scripts from the component
                @endphp
            @endpush
        @endif
    @endforeach
</body>
</html>
