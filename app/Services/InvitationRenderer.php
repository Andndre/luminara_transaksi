<?php

namespace App\Services;

use App\Models\InvitationPage;
use App\Models\InvitationSection;

class InvitationRenderer
{
    protected $page;
    protected $sections;

    public function render(InvitationPage $page): string
    {
        $this->page = $page;
        $this->sections = $page->sections()
            ->orderBy('order_index')
            ->where('is_visible', true)
            ->get();

        $html = '';

        foreach ($this->sections as $section) {
            $html .= $this->renderSection($section);
        }

        return $html;
    }

    protected function renderSection(InvitationSection $section): string
    {
        $viewPath = "templates.components.{$section->section_type}";

        if (!view()->exists($viewPath)) {
            return "<!-- Component {$section->section_type} not found -->";
        }

        return view($viewPath, [
            'props' => $section->props,
            'section' => $section,
            'page' => $this->page
        ])->render();
    }

    public function toArray(InvitationPage $page): array
    {
        return [
            'page' => $page,
            'sections' => $page->sections()->orderBy('order_index')->get(),
            'assets' => $page->assets
        ];
    }
}
