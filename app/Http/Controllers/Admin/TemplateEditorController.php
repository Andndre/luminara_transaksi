<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvitationTemplate;
use App\Models\InvitationSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateEditorController extends Controller
{
    public function editor($id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::with(['sections', 'creator'])->findOrFail($id);
        return view('admin.templates.editor', compact('template'));
    }

    public function load($id)
    {
        $template = InvitationTemplate::with(['sections' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);

        return response()->json([
            'template' => $template,
            'sections' => $template->sections,
        ]);
    }

    public function saveSection(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:invitation_templates,id',
            'sections' => 'required|array',
            'sections.*.id' => 'required',
            'sections.*.section_type' => 'required|string',
            'sections.*.order_index' => 'required|integer',
            'sections.*.props' => 'required|array',
        ]);

        $templateId = $request->template_id;
        $sections = $request->sections;
        $savedSections = [];

        foreach ($sections as $sectionData) {
            if (str_starts_with($sectionData['id'], 'temp-')) {
                // New section
                $newSection = InvitationSection::create([
                    'template_id' => $templateId,
                    'page_id' => null, // Template sections don't belong to a page
                    'section_type' => $sectionData['section_type'],
                    'order_index' => $sectionData['order_index'],
                    'props' => $sectionData['props'],
                ]);
                $savedSections[] = [
                    'temp_id' => $sectionData['id'],
                    'id' => $newSection->id
                ];
            } else {
                // Update existing section
                $section = InvitationSection::find($sectionData['id']);
                if ($section && $section->template_id == $templateId) {
                    $section->update([
                        'order_index' => $sectionData['order_index'],
                        'props' => $sectionData['props'],
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Sections saved',
            'sections' => $savedSections
        ]);
    }

    public function updateSection(Request $request, $id)
    {
        $section = InvitationSection::findOrFail($id);
        $section->update($request->only(['props', 'custom_css', 'is_visible']));

        return response()->json(['success' => true, 'section' => $section]);
    }

    public function deleteSection($id)
    {
        $section = InvitationSection::findOrFail($id);
        $section->delete();

        return response()->json(['success' => true, 'message' => 'Section deleted']);
    }

    public function reorderSections(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:invitation_sections,id',
            'sections.*.order_index' => 'required|integer',
        ]);

        foreach ($request->sections as $sectionData) {
            $section = InvitationSection::find($sectionData['id']);
            if ($section) {
                $section->update(['order_index' => $sectionData['order_index']]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function publish(Request $request, $id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::findOrFail($id);
        $template->update(['is_active' => true]);

        return response()->json(['success' => true, 'message' => 'Template published']);
    }

    public function preview($id)
    {
        $template = InvitationTemplate::with(['sections' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);

        return view('admin.templates.preview', compact('template'));
    }
}
