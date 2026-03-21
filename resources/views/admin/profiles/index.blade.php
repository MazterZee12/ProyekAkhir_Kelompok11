@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Profiles</h4>
        <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary">
            + Add Profile
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th width="120">Logo</th>
                        <th>Name</th>
                        <th>Established</th>
                        <th width="80">Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($profiles as $profile)
                    <tr>
                        <td>{{ $profiles->firstItem() + $loop->index }}</td>
                        <td>
                            @if($profile->logo_path)
                                <img src="{{ asset('storage/'.$profile->logo_path) }}" width="80" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                        <td><strong>{{ $profile->name }}</strong></td>
                        <td>{{ $profile->established_year ?? '-' }}</td>
                        <td>
                            @if($profile->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.profiles.show', $profile->id) }}" class="btn btn-sm btn-info">
                                View
                            </a>
                            <a href="{{ route('admin.profiles.edit', $profile->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('admin.profiles.destroy', $profile->id) }}" method="POST"
                                onsubmit="return confirm('Delete this profile?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No profiles found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $profiles->links() }}</div>
        </div>
    </div>
</div>
@endsection
