<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InformationRequestController extends Controller
{
    /**
     * Daftar semua permintaan
     */
    public function index(Request $request)
    {
        $query = InformationRequest::with('user')->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $informationRequests = $query->paginate(15);

        $total    = InformationRequest::count();
        $pending  = InformationRequest::pending()->count();
        $answered = InformationRequest::answered()->count();
        $closed   = InformationRequest::closed()->count();

        return view('admin.information-requests.index', compact(
            'informationRequests',
            'total',
            'pending',
            'answered',
            'closed'
        ));
    }

    /**
     * Detail permintaan
     */
    public function show(InformationRequest $informationRequest)
    {
        return view('admin.information-requests.show', compact('informationRequest'));
    }

    /**
     * Jawab permintaan
     */
    public function answer(Request $request, InformationRequest $informationRequest)
    {
        $data = $request->validate([
            'response' => 'required|string|min:5',
        ], [
            'response.required' => 'Jawaban wajib diisi.',
            'response.min'      => 'Jawaban minimal 5 karakter.',
        ]);

        try {
            $informationRequest->update([
                'response'     => $data['response'],
                'status'       => InformationRequest::STATUS_ANSWERED,
                'responded_at' => now(),
            ]);

            return redirect()
                ->route('admin.information-requests.show', $informationRequest)
                ->with('success', 'Jawaban berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('InformationRequestController::answer failed', [
                'id'    => $informationRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim jawaban.');
        }
    }

    /**
     * Ubah status permintaan
     */
    public function updateStatus(Request $request, InformationRequest $informationRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,answered,closed',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        try {
            $informationRequest->update([
                'status' => $request->status,
            ]);

            return redirect()
                ->route('admin.information-requests.show', $informationRequest)
                ->with('success', 'Status permintaan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('InformationRequestController::updateStatus failed', [
                'id'    => $informationRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Gagal memperbarui status.');
        }
    }
}
