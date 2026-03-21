@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Contact Detail</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Address</th>
                    <td>{{ $contact->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $contact->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $contact->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Instagram</th>
                    <td>{{ $contact->instagram ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Facebook</th>
                    <td>{{ $contact->facebook ?? '-' }}</td>
                </tr>
                <tr>
                    <th>YouTube</th>
                    <td>{{ $contact->youtube ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Twitter</th>
                    <td>{{ $contact->twitter ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Google Maps</th>
                    <td>
                        @if($contact->google_maps_embed)
                            <div>{!! $contact->google_maps_embed !!}</div>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Views</th>
                    <td>{{ $contact->views }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($contact->is_active)
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
