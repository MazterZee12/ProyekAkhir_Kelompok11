@extends('layouts.admin')

@section('content')

<div class="container">

    <h4 class="mb-4">Create Announcement</h4>

    <form
        action="{{ route('admin.announcements.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include('admin.announcements._form')

    </form>

</div>

@endsection
