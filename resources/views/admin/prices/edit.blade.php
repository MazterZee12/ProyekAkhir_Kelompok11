@extends('layouts.admin')

@section('content')

<h4>Edit Price</h4>

<form method="POST"
action="{{ route('admin.prices.update',$price) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

@include('admin.prices._form')

<button class="btn btn-primary">
Update
</button>

<a href="{{ route('admin.prices.index') }}"
class="btn btn-secondary">
Back
</a>

</form>

@endsection
