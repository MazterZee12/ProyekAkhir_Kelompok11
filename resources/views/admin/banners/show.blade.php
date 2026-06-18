@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Banner Detail</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                @if($banner->media)
                    <img src="{{ $banner->media->url }}" width="300" class="img-thumbnail">
                @endif
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="200">Title</th>
                    <td>{{ $banner->title }}</td>
                </tr>
                <tr>
                    <th>Subtitle</th>
                    <td>{{ $banner->subtitle ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Order</th>
                    <td>{{ $banner->order }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($banner->is_active)
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
