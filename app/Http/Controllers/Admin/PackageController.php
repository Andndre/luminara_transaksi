<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $userAuth = Auth::user()->id;
        $user = User::find($userAuth);
        $query = Package::with('prices');
        
        if ($user->division !== 'super_admin') {
            $query->where('business_unit', $user->division);
        }

        $packages = $query->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50|unique:packages,type',
            'base_price' => 'required|numeric|min:0',
            'business_unit' => 'nullable|in:photobooth,visual',
            'description' => 'nullable|string',
            'prices.*.duration' => 'required|integer|min:1',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.description' => 'nullable|string',
        ]);

        $userAuth = Auth::user()->id;
        $user = User::find($userAuth);
        
        // Use request business_unit if super_admin, otherwise use user's division
        $businessUnit = ($user->division === 'super_admin') 
            ? ($request->business_unit ?? 'photobooth') 
            : $user->division;

        $package = Package::create([
            'name' => $request->name,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'is_active' => true,
            'business_unit' => $businessUnit,
        ]);

        if ($request->has('prices')) {
            foreach ($request->prices as $priceData) {
                $package->prices()->create([
                    'duration_hours' => $priceData['duration'],
                    'price' => $priceData['price'],
                    'description' => $priceData['description'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        $package->load('prices');
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', 'string', 'max:50', Rule::unique('packages')->ignore($package->id)],
            'base_price' => 'required|numeric|min:0',
            'business_unit' => 'nullable|in:photobooth,visual',
            'description' => 'nullable|string',
            'prices.*.duration' => 'required|integer|min:1',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.description' => 'nullable|string',
        ]);

        $userAuth = Auth::user()->id;
        $user = User::find($userAuth);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        // Only allow super_admin to change business_unit
        if ($user->division === 'super_admin' && $request->has('business_unit')) {
            $data['business_unit'] = $request->business_unit;
        }

        $package->update($data);

        // Sync prices: Delete old and create new
        $package->prices()->delete();

        if ($request->has('prices')) {
            foreach ($request->prices as $priceData) {
                if ($priceData['duration'] && $priceData['price']) {
                     $package->prices()->create([
                        'duration_hours' => $priceData['duration'],
                        'price' => $priceData['price'],
                        'description' => $priceData['description'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket dihapus.');
    }
}