@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Banners</h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            + Add Banner
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th width="150">Image</th>
                        <th>Title</th>
                        <th width="80">Order</th>
                        <th width="80">Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>{{ $banners->firstItem() + $loop->index }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$banner->image_path) }}" width="120" class="img-thumbnail">
                        </td>
                        <td><strong>{{ $banner->title }}</strong></td>
                        <td>{{ $banner->order }}</td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                onsubmit="return confirm('Delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No banners found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $banners->links() }}</div>
        </div>
    </div>
</div>
@endsection
