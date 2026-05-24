@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>FAQs</h4>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            + Add FAQ
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Question</th>
                        <th width="70">Order</th>
                        <th width="80">Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>{{ $faqs->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $faq->question }}</strong></td>
                        <td>{{ $faq->order }}</td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.faqs.show', $faq->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                onsubmit="return confirm('Delete this FAQ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No FAQs found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $faqs->links() }}</div>
        </div>
    </div>
</div>
@endsection
