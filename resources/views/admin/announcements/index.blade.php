@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Announcements</h4>

        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
            + Create Announcement
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th width="120">Image</th>
                        <th>Title</th>
                        <th width="120">Status</th>
                        <th width="150">Start Date</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($announcements as $announcement)

                    <tr>

                        {{-- Number --}}
                        <td>
                            {{ $announcements->firstItem() + $loop->index }}
                        </td>

                        {{-- Image --}}
                        <td>
                            @if($announcement->photo_path)
                                <img
                                    src="{{ asset('storage/'.$announcement->photo_path) }}"
                                    width="80"
                                    class="img-thumbnail"
                                >
                            @else
                                -
                            @endif
                        </td>

                        {{-- Title --}}
                        <td>
                            <strong>{{ $announcement->title }}</strong>
                        </td>

                        {{-- Status --}}
                        <td>

                            @if($announcement->status == 'active')

                                <span class="badge bg-success">
                                    Published
                                </span>

                            @elseif($announcement->status == 'scheduled')

                                <span class="badge bg-warning">
                                    Scheduled
                                </span>

                            @elseif($announcement->status == 'expired')

                                <span class="badge bg-danger">
                                    Expired
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Draft
                                </span>

                            @endif

                        </td>

                        {{-- Start Date --}}
                        <td>
                            {{ $announcement->starts_at
                                ? $announcement->starts_at->format('d M Y')
                                : '-' }}
                        </td>

                        {{-- Action --}}
                        <td class="d-flex gap-1">

                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                class="btn btn-sm btn-warning"
                            >
                                Edit
                            </a>

                            {{-- Toggle Publish --}}
                            <form
                                action="{{ route('admin.announcements.toggle',$announcement->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                @if($announcement->is_active)

                                    <button class="btn btn-sm btn-secondary">
                                        Unpublish
                                    </button>

                                @else

                                    <button class="btn btn-sm btn-success">
                                        Publish
                                    </button>

                                @endif

                            </form>

                            {{-- Delete --}}
                            <form
                                action="{{ route('admin.announcements.destroy',$announcement->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this announcement?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No announcements found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $announcements->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
