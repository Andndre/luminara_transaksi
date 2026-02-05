<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvitationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $templates = InvitationTemplate::all();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:invitation_templates',
        ]);

        InvitationTemplate::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->is_active ?? true,
            'created_by' => $currentUserId,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dibuat.');
    }

    public function edit($id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::findOrFail($id);
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:invitation_templates,slug,' . $id,
        ]);

        $template->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'thumbnail' => $request->thumbnail,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dihapus.');
    }

    public function duplicate($id)
    {
        $currentUserId = Auth::id();
        $currentUser = \App\Models\User::find($currentUserId);

        if ($currentUser->division !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        $template = InvitationTemplate::findOrFail($id);
        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (Copy)';
        $newTemplate->slug = $template->slug . '-copy';
        $newTemplate->created_by = $currentUserId;
        $newTemplate->save();

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil diduplikasi.');
    }
}
