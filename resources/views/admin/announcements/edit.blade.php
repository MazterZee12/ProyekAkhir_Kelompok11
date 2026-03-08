@extends('layouts.admin')

@section('content')

<div class="container">

    <h4 class="mb-4">Edit Announcement</h4>

    <form
        action="{{ route('admin.announcements.update', $announcement->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.announcements._form')

    </form>

</div>

@endsection
