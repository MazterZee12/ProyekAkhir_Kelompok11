@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Create Contact</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.contacts.store') }}" method="POST">
                @csrf
                @include('admin.contacts._form')
                <button class="btn btn-primary">Save Contact</button>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
