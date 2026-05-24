@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Buat Jadwal</h4>
    <form action="{{ route('admin.schedules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                @include('admin.schedules._form')
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
