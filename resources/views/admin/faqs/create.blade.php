@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Create FAQ</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                @include('admin.faqs._form')
                <button class="btn btn-primary">Save FAQ</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
