<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InformationRequestController extends Controller
{
    public function index()
    {
        $informationRequests = InformationRequest::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $total = InformationRequest::where('user_id', Auth::id())->count();
        $pending = InformationRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();
        $answered = InformationRequest::where('user_id', Auth::id())
            ->where('status', 'answered')
            ->count();

        return view('public.information-requests.index', compact(
            'informationRequests',
            'total',
            'pending',
            'answered'
        ));
    }

    public function create()
    {
        return view('public.information-requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'subject.required' => 'Subjek wajib diisi.',
            'subject.max'      => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal 10 karakter.',
            'message.max'      => 'Pesan maksimal 5000 karakter.',
        ]);

        try {
            $userId = Auth::id();

            // Batasi maksimal 3 permintaan yang masih pending
            $pendingCount = InformationRequest::where('user_id', $userId)
                ->where('status', 'pending')
                ->count();

            if ($pendingCount >= 3) {
                return back()
                    ->withInput()
                    ->with('error', 'Kamu masih memiliki 3 permintaan yang belum dijawab admin. Tunggu sampai salah satunya dijawab terlebih dahulu.');
            }

            // Cooldown 10 menit dari request terakhir
            $lastRequest = InformationRequest::where('user_id', $userId)
                ->latest()
                ->first();

            if ($lastRequest && $lastRequest->created_at->diffInMinutes(now()) < 10) {
                $waitMinutes = 10 - $lastRequest->created_at->diffInMinutes(now());

                return back()
                    ->withInput()
                    ->with('error', 'Tunggu sekitar ' . $waitMinutes . ' menit sebelum mengirim permintaan berikutnya.');
            }

            InformationRequest::create([
                'user_id' => $userId,
                'subject'  => $validated['subject'],
                'message'  => $validated['message'],
                'status'   => 'pending',
            ]);

            return redirect()
                ->route('information-requests.index')
                ->with('success', 'Permintaan informasi berhasil dikirim.');

        } catch (\Exception $e) {
            Log::error('Public\\InformationRequestController::store failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim permintaan informasi.');
        }
    }

    public function show(InformationRequest $informationRequest)
    {
        abort_unless($informationRequest->user_id === Auth::id(), 403);

        return view('public.information-requests.show', compact('informationRequest'));
    }

    public function edit(InformationRequest $informationRequest)
    {
        abort_unless($informationRequest->user_id === Auth::id(), 403);

        if ($informationRequest->status !== 'pending') {
            return redirect()
                ->route('information-requests.show', $informationRequest)
                ->with('error', 'Permintaan yang sudah dijawab tidak bisa diedit.');
        }

        return view('public.information-requests.edit', compact('informationRequest'));
    }

    public function update(Request $request, InformationRequest $informationRequest)
    {
        abort_unless($informationRequest->user_id === Auth::id(), 403);

        if ($informationRequest->status !== 'pending') {
            return redirect()
                ->route('information-requests.show', $informationRequest)
                ->with('error', 'Permintaan yang sudah dijawab tidak bisa diubah.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'subject.required' => 'Subjek wajib diisi.',
            'subject.max'      => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal 10 karakter.',
            'message.max'      => 'Pesan maksimal 5000 karakter.',
        ]);

        try {
            $informationRequest->update([
                'subject' => $validated['subject'],
                'message' => $validated['message'],
            ]);

            return redirect()
                ->route('information-requests.show', $informationRequest)
                ->with('success', 'Permintaan informasi berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Public\\InformationRequestController::update failed', [
                'id'    => $informationRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui permintaan informasi.');
        }
    }

    public function destroy(InformationRequest $informationRequest)
    {
        abort_unless($informationRequest->user_id === Auth::id(), 403);

        if ($informationRequest->status !== 'pending') {
            return redirect()
                ->route('information-requests.show', $informationRequest)
                ->with('error', 'Permintaan yang sudah dijawab tidak bisa dihapus.');
        }

        try {
            $informationRequest->delete();

            return redirect()
                ->route('information-requests.index')
                ->with('success', 'Permintaan informasi berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Public\\InformationRequestController::destroy failed', [
                'id'    => $informationRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus permintaan informasi.');
        }
    }
}
