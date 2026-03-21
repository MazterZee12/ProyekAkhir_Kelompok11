@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit FAQ</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.faqs._form')
                <button class="btn btn-primary">Update FAQ</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
