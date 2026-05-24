@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Banner</h4>
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                @include('admin.banners._form')
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
