@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Contacts</h4>
        <a href="{{ route('admin.contacts.create') }}" class="btn btn-primary">+ Add Contact</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="90">Status</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $contacts->firstItem() + $loop->index }}</td>
                        <td>{{ $contact->address ?? '-' }}</td>
                        <td>{{ $contact->email ?? '-' }}</td>
                        <td>{{ $contact->phone ?? '-' }}</td>
                        <td>
                            @if($contact->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.contacts.edit', $contact->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $contact->id }}"
                                data-title="{{ $contact->email ?? $contact->address }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No contacts found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $contacts->links() }}</div>
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
                Apakah kamu yakin ingin menghapus contact
                <strong id="deleteContactTitle"></strong>?
                Tindakan ini tidak bisa dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('deleteContactTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/contacts/' + btn.getAttribute('data-id');
});
</script>
@endpush
