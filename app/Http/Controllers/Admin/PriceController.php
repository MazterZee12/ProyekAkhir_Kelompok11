<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Services\FileUploadService;

class PriceController extends Controller
{
    protected $upload;

    public function __construct(FileUploadService $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Tampilkan daftar harga.
     */
    public function index()
    {
        $prices = Price::orderBy('type')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.prices.index', compact('prices'));
    }

    /**
     * Form create
     */
    public function create()
    {
        return view('admin.prices.create');
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:ticket,rental',
            'amount' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {

            $data['photo_path'] = $this->upload->upload(
                $request->file('photo'),
                'prices'
            );

        }

        Price::create($data);

        return redirect()
            ->route('admin.prices.index')
            ->with('success', 'Price created successfully.');
    }

    /**
     * Show
     */
    public function show(Price $price)
    {
        return view('admin.prices.show', compact('price'));
    }

    /**
     * Edit
     */
    public function edit(Price $price)
    {
        return view('admin.prices.edit', compact('price'));
    }

    /**
     * Update
     */
    public function update(Request $request, Price $price)
    {
        $data = $request->validate([
            'type' => 'required|in:ticket,rental',
            'amount' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {

            $data['photo_path'] = $this->upload->replace(
                $price->photo_path,
                $request->file('photo'),
                'prices'
            );

        }

        $price->update($data);

        return redirect()
            ->route('admin.prices.index')
            ->with('success', 'Price updated.');
    }

    /**
     * Delete
     */
    public function destroy(Price $price)
    {
        $this->upload->delete($price->photo_path);

        $price->delete();

        return redirect()
            ->route('admin.prices.index')
            ->with('success', 'Price deleted.');
    }

    /**
     * Toggle
     */
    public function toggle(Price $price)
    {
        $price->is_active = !$price->is_active;
        $price->save();

        return back()->with('success', 'Status updated.');
    }

    /**
     * Food gallery
     */
    public function foodGallery()
    {
        $foods = Price::where('type','rental')
            ->whereNotNull('photo_path')
            ->where('is_active',true)
            ->latest()
            ->get();

        return view('admin.prices.food_gallery', compact('foods'));
    }
}
