@extends('layouts.admin')

@section('content')

<div class="container">
<h4 class="mb-4">Gallery Detail</h4>
<div class="card">
<div class="card-body text-center">

@if($gallery->type == 'photo')
<img src="{{ $gallery->media->url }}" class="img-fluid mb-3">
@else
<video controls width="600" class="mb-3">
<source src="{{ $gallery->media->url }}">
</video>
@endif

<h5>{{ $gallery->title }}</h5>
<p class="text-muted">
{{ $gallery->description }}
</p>
<a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
Back
</a>
</div>
</div>
</div>
@endsection
