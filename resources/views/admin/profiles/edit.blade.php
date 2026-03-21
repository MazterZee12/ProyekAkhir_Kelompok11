@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Profile</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.profiles._form')
                <button class="btn btn-primary">Update Profile</button>
                <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
