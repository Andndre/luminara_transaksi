<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvitationPage;
use App\Models\InvitationSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationEditorController extends Controller
{
    public function editor($id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $page = InvitationPage::with(['sections', 'template'])->findOrFail($id);
        return view('admin.invitations.editor', compact('page'));
    }

    public function load($id)
    {
        $page = InvitationPage::with(['sections' => function ($query) {
            $query->orderBy('order_index');
        }])->findOrFail($id);

        return response()->json([
            'page' => $page,
            'sections' => $page->sections,
        ]);
    }

    public function saveSection(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:invitation_pages,id',
            'sections' => 'required|array',
            'sections.*.id' => 'required',
            'sections.*.section_type' => 'required|string',
            'sections.*.order_index' => 'required|integer',
            'sections.*.props' => 'required|array',
        ]);

        $pageId = $request->page_id;
        $sections = $request->sections;

        foreach ($sections as $sectionData) {
            if (str_starts_with($sectionData['id'], 'temp-')) {
                // New section
                InvitationSection::create([
                    'page_id' => $pageId,
                    'section_type' => $sectionData['section_type'],
                    'order_index' => $sectionData['order_index'],
                    'props' => $sectionData['props'],
                ]);
            } else {
                // Update existing section
                $section = InvitationSection::find($sectionData['id']);
                if ($section && $section->page_id == $pageId) {
                    $section->update([
                        'order_index' => $sectionData['order_index'],
                        'props' => $sectionData['props'],
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Sections saved']);
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

        $page = InvitationPage::findOrFail($id);
        $page->update(['published_status' => 'published']);

        return response()->json(['success' => true, 'message' => 'Invitation published']);
    }
}
