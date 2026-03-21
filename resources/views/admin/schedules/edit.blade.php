@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Schedule</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.schedules._form')
                <button class="btn btn-primary">Update Schedule</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
