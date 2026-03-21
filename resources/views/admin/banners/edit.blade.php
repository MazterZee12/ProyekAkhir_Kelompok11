@extends('layouts.admin')
@section('content')
<div class="container">
    <h4 class="mb-4">Edit Banner</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.banners._form')
                <button class="btn btn-primary">Update Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
