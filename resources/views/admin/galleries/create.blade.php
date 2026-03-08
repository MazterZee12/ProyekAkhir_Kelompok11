@extends('layouts.admin')

@section('content')

<div class="container">

<h4 class="mb-4">Upload Gallery</h4>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">

@include('admin.galleries._form')

<button class="btn btn-primary">
Save Gallery
</button>

<a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
Cancel
</a>

</form>

</div>
</div>

</div>

@endsection
