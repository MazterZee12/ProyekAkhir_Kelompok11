@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Create Schedule</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                @include('admin.schedules._form')
                <button class="btn btn-primary">Save Schedule</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
