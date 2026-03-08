@extends('layouts.admin')

@section('content')

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Profile Information</h4>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.profiles.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- History -->
            <div class="mb-3">
                <label class="form-label">History</label>
                <textarea name="history" class="form-control" rows="4">{{ old('history',$profile->history) }}</textarea>
            </div>

            <!-- Vision -->
            <div class="mb-3">
                <label class="form-label">Vision</label>
                <textarea name="vision" class="form-control" rows="3">{{ old('vision',$profile->vision) }}</textarea>
            </div>

            <!-- Mission -->
            <div class="mb-3">
                <label class="form-label">Mission</label>
                <textarea name="mission" class="form-control" rows="3">{{ old('mission',$profile->mission) }}</textarea>
            </div>

            <!-- Manager Name -->
            <div class="mb-3">
                <label class="form-label">Manager Name</label>
                <input type="text"
                       name="manager_name"
                       class="form-control"
                       value="{{ old('manager_name',$profile->manager_name) }}">
            </div>

            <!-- Manager Email -->
            <div class="mb-3">
                <label class="form-label">Manager Email</label>
                <input type="email"
                       name="manager_email"
                       class="form-control"
                       value="{{ old('manager_email',$profile->manager_email) }}">
            </div>

            <!-- Manager Phone -->
            <div class="mb-3">
                <label class="form-label">Manager Phone</label>
                <input type="text"
                       name="manager_phone"
                       class="form-control"
                       value="{{ old('manager_phone',$profile->manager_phone) }}">
            </div>

            <!-- Logo -->
            <div class="mb-3">
                <label class="form-label">Logo</label>

                @if($profile->logo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$profile->logo_path) }}"
                             width="120"
                             class="img-thumbnail">
                    </div>
                @endif

                <input type="file" name="logo" class="form-control">
            </div>

            <!-- Active -->
            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active',$profile->is_active ?? true) ? 'checked' : '' }}>

                <label class="form-check-label">
                    Active Profile
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Profile
            </button>

        </form>

    </div>
</div>
```

</div>

@endsection
