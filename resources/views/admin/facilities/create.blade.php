@extends('layouts.admin')

@section('content')

<div class="container">

<h4 class="mb-4">Create Facility</h4>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="mb-3">
<label class="form-label">Facility Name</label>

<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>

<textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
<label class="form-label">Photo</label>

<input type="file" name="photo" class="form-control">
</div>

<button class="btn btn-primary">
Save Facility
</button>

<a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
Cancel
</a>

</form>

</div>
</div>

</div>

@endsection
