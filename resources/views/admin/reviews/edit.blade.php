@extends('layouts.admin')
@section('title','Edit Review')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Review</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.reviews._form')
                <button class="btn btn-primary">Update Review</button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
