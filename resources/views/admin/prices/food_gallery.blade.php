@extends('layouts.admin')

@section('content')

<h4>Food Gallery</h4>

<div class="row">

@foreach($foods as $food)

<div class="col-md-3 mb-4">

<div class="card">

@if($food->photo_path)
<img src="{{ asset('storage/'.$food->photo_path) }}"
class="card-img-top">
@endif

<div class="card-body">

<h6>{{ $food->unit }}</h6>

<p>{{ $food->formatted_amount }}</p>

</div>

</div>

</div>

@endforeach

</div>

@endsection
