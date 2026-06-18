<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PriceController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $prices = Price::with('media')->orderBy('type')->orderBy('created_at', 'desc')->paginate(20);
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
                $data['media_id'] = $this->media->store(
                    $request->file('photo'),
                    'prices'
                )->id;
            }

            Price::create($data);

            return redirect()
                ->route('admin.prices.index')
                ->with('success', 'Harga berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('PriceController::store failed', ['error' => $e->getMessage()]);
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
                $data['media_id'] = $price->media
                    ? $this->media->replace($price->media, $request->file('photo'), 'prices')->id
                    : $this->media->store($request->file('photo'), 'prices')->id;
            }

            $price->update($data);

            return redirect()
                ->route('admin.prices.index')
                ->with('success', 'Harga berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('PriceController::update failed', [
                'id'    => $price->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui harga.');
        }
    }

    public function destroy(Price $price)
    {
        try {
            if ($price->media) {
                $this->media->delete($price->media);
            }
            $price->delete();

            return redirect()
                ->route('admin.prices.index')
                ->with('success', 'Harga berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('PriceController::destroy failed', [
                'id'    => $price->id,
                'error' => $e->getMessage(),
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
            return back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('PriceController::toggle failed', [
                'id'    => $price->id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal memperbarui status.');
        }
    }
}
