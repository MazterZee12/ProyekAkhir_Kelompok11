@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Contact</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.contacts._form')
                <button class="btn btn-primary">Update Contact</button>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
