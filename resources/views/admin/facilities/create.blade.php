@extends('layouts.admin')
@section('content')
<div class="container">
    <h4 class="mb-4">Buat Fasilitas</h4>
    <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                @include('admin.facilities._form')
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
