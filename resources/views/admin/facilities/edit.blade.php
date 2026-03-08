@extends('layouts.admin')

@section('content')

<div class="container">

<h4 class="mb-4">Edit Facility</h4>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.facilities.update',$facility->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="mb-3">
<label class="form-label">Facility Name</label>

<input type="text" name="name" class="form-control" value="{{ $facility->name }}" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>

<textarea name="description" class="form-control">{{ $facility->description }}</textarea>
</div>

<div class="mb-3">
<label class="form-label">Photo</label>

@if($facility->photo_path)
<div class="mb-2">
<img src="{{ asset('storage/'.$facility->photo_path) }}" width="120">
</div>
@endif

<input type="file" name="photo" class="form-control">
</div>

<button class="btn btn-primary">
Update Facility
</button>

<a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
Cancel
</a>

</form>

</div>
</div>

</div>

@endsection
