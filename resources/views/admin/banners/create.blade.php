@extends('layouts.admin')
@section('content')
<div class="container">
    <h4 class="mb-4">Create Banner</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.banners._form')
                <button class="btn btn-primary">Save Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
