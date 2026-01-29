<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackagePrice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('prices')->get();
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
            'description' => 'nullable|string',
            'prices.*.duration' => 'required|integer|min:1',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.description' => 'nullable|string',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'is_active' => true,
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
            'description' => 'nullable|string',
            'prices.*.duration' => 'required|integer|min:1',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.description' => 'nullable|string',
        ]);

        $package->update([
            'name' => $request->name,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        // Sync prices: Delete old and create new (Simpler than updating individually for now)
        $package->prices()->delete();

        if ($request->has('prices')) {
            foreach ($request->prices as $priceData) {
                // Filter out empty rows if any
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