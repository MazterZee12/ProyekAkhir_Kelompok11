@extends('layouts.admin')

@section('content')

<div class="container">

<h4 class="mb-4">Edit Gallery</h4>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.galleries.update',$gallery->id) }}" method="POST" enctype="multipart/form-data">

@method('PUT')

@include('admin.galleries._form')

<button class="btn btn-primary">
Update Gallery
</button>

<a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
Cancel
</a>

</form>

</div>
</div>

</div>

@endsection
