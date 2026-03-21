@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>FAQ Detail</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Question</th>
                    <td>{{ $faq->question }}</td>
                </tr>
                <tr>
                    <th>Answer</th>
                    <td>{{ $faq->answer }}</td>
                </tr>
                <tr>
                    <th>Order</th>
                    <td>{{ $faq->order }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($faq->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
