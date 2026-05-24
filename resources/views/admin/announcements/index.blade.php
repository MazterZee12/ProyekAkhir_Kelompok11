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

            <table class="table table-bordered table-striped align-middle">

                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="100">Image</th>
                        <th>Title</th>
                        <th width="110">Status</th>
                        <th width="120">Start Date</th>
                        <th width="120">End Date</th>
                        <th width="210">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($announcements as $announcement)
                    <tr>

                        {{-- Number --}}
                        <td>{{ $announcements->firstItem() + $loop->index }}</td>

                        {{-- Image --}}
                        <td>
                            @if($announcement->photo_path)
                                <img
                                    src="{{ asset('storage/'.$announcement->photo_path) }}"
                                    width="80"
                                    class="img-thumbnail"
                                >
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Title --}}
                        <td>
                            <strong>{{ $announcement->title }}</strong>
                            @if($announcement->is_featured)
                                <span class="badge bg-info ms-1">Featured</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($announcement->status == 'active')
                                <span class="badge bg-success">Published</span>
                            @elseif($announcement->status == 'scheduled')
                                <span class="badge bg-warning text-dark">Scheduled</span>
                            @elseif($announcement->status == 'expired')
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>

                        {{-- Start Date --}}
                        <td>
                            {{ $announcement->starts_at
                                ? $announcement->starts_at->format('d M Y')
                                : '-' }}
                        </td>

                        {{-- End Date --}}
                        <td>
                            {{ $announcement->ends_at
                                ? $announcement->ends_at->format('d M Y')
                                : '-' }}
                        </td>

                        {{-- Action --}}
                        <td style="white-space:nowrap;">

                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                class="btn btn-sm btn-warning"
                            >Edit</a>

                            {{-- Toggle Publish --}}
                            <form
                                action="{{ route('admin.announcements.toggle', $announcement->id) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('PATCH')
                                @if($announcement->is_active)
                                    <button class="btn btn-sm btn-secondary">Unpublish</button>
                                @else
                                    <button class="btn btn-sm btn-success">Publish</button>
                                @endif
                            </form>

                            {{-- Delete — trigger modal --}}
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $announcement->id }}"
                                data-title="{{ $announcement->title }}"
                            >Hapus</button>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No announcements found.
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

{{-- Modal Konfirmasi Delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Apakah kamu yakin ingin menghapus announcement
                <strong id="deleteAnnouncementTitle"></strong>?
                Tindakan ini tidak bisa dibatalkan.
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const btn   = event.relatedTarget;
        const id    = btn.getAttribute('data-id');
        const title = btn.getAttribute('data-title');

        document.getElementById('deleteAnnouncementTitle').textContent = title;
        document.getElementById('deleteForm').action =
            '/admin/announcements/' + id;
    });

    document.querySelectorAll('.js-alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity    = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 4000);
    });

});
</script>
@endpush
