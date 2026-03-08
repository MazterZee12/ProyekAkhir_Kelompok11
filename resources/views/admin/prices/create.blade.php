@extends('layouts.admin')

@section('content')

<h4>Create Price</h4>

<form method="POST"
action="{{ route('admin.prices.store') }}"
enctype="multipart/form-data">

@csrf

@include('admin.prices._form')

<button class="btn btn-primary">
Save
</button>

<a href="{{ route('admin.prices.index') }}"
class="btn btn-secondary">
Back
</a>

</form>

@endsection
