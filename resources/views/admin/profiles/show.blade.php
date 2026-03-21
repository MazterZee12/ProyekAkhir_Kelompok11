@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Profile Detail</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.profiles.edit', $profile->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if($profile->logo_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/'.$profile->logo_path) }}" width="150" class="img-thumbnail">
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th width="200">Name</th>
                    <td>{{ $profile->name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $profile->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>History</th>
                    <td>{{ $profile->history ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Vision</th>
                    <td>{{ $profile->vision ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Mission</th>
                    <td>{{ $profile->mission ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Established Year</th>
                    <td>{{ $profile->established_year ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Regulations</th>
                    <td>{{ $profile->regulations ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($profile->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
