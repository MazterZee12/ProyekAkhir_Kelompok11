<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;

class PriceController extends Controller
{
    protected $upload;

    public function __construct(FileUploadService $upload)
    {
        $this->upload = $upload;
    }

    public function index()
    {
        $prices = Price::orderBy('type')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.prices.index', compact('prices'));
    }

    public function create()
    {
        $price = null;
        return view('admin.prices.create', compact('price'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'   => 'required|in:ticket,rental',
            'amount' => 'required|numeric|min:0',
            'unit'   => 'required|string|max:50',
            'notes'  => 'nullable|string',
            'photo'  => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        try {
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

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('PriceController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan harga.');
        }
    }

    public function show(Price $price)
    {
        return view('admin.prices.show', compact('price'));
    }

    public function edit(Price $price)
    {
        return view('admin.prices.edit', compact('price'));
    }

    public function update(Request $request, Price $price)
    {
        $data = $request->validate([
            'type'   => 'required|in:ticket,rental',
            'amount' => 'required|numeric|min:0',
            'unit'   => 'required|string|max:50',
            'notes'  => 'nullable|string',
            'photo'  => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        try {
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

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('PriceController::update failed', [
                'id'    => $price->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui harga.');
        }
    }

    public function destroy(Price $price)
    {
        try {
            $this->upload->delete($price->photo_path);
            $price->delete();

            return redirect()
                ->route('admin.prices.index')
                ->with('success', 'Price deleted.');

        } catch (\Exception $e) {
            Log::error('PriceController::destroy failed', [
                'id'    => $price->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.prices.index')
                ->with('error', 'Gagal menghapus harga.');
        }
    }

    public function toggle(Price $price)
    {
        try {
            $price->is_active = !$price->is_active;
            $price->save();

            return back()->with('success', 'Status updated.');

        } catch (\Exception $e) {
            Log::error('PriceController::toggle failed', [
                'id'    => $price->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memperbarui status harga.');
        }
    }
}
