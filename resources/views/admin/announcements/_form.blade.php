@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Title --}}
<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text"
           name="title"
           class="form-control"
           value="{{ old('title', $announcement?->title ?? '') }}"
           required>
</div>

{{-- Content --}}
<div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content"
              class="form-control"
              rows="5"
              required>{{ old('content', $announcement?->content ?? '') }}</textarea>
</div>

{{-- Type --}}
<div class="mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-control" required>
        <option value="event" {{ old('type', $announcement?->type ?? '') == 'event' ? 'selected' : '' }}>Event</option>
        <option value="promo" {{ old('type', $announcement?->type ?? '') == 'promo' ? 'selected' : '' }}>Promo</option>
        <option value="info"  {{ old('type', $announcement?->type ?? '') == 'info'  ? 'selected' : '' }}>Info</option>
    </select>
</div>

{{-- Start Date --}}
<div class="mb-3">
    <label class="form-label">Start Date</label>
    <input type="date"
           name="starts_at"
           id="starts_at"
           class="form-control"
           min="{{ date('Y-m-d') }}"
           value="{{ old('starts_at', $announcement?->starts_at?->format('Y-m-d') ?? '') }}">
</div>

{{-- End Date --}}
<div class="mb-3">
    <label class="form-label">End Date</label>
    <input type="date"
           name="ends_at"
           id="ends_at"
           class="form-control"
           min="{{ date('Y-m-d') }}"
           value="{{ old('ends_at', $announcement?->ends_at?->format('Y-m-d') ?? '') }}">
</div>

{{-- Publish Status --}}
<div class="mb-3">
    <label class="form-label">Publish Status</label>
    <div class="form-check">
        <input class="form-check-input"
               type="checkbox"
               name="is_active"
               value="1"
               id="publishCheck"
               {{ old('is_active', $announcement?->is_active ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="publishCheck">
            Publish Announcement
        </label>
    </div>
    <small class="text-muted">
        Jika tidak dicentang maka announcement akan disimpan sebagai draft.
    </small>
</div>

{{-- Featured --}}
<div class="mb-3">
    <label class="form-label">Featured</label>
    <div class="form-check">
        <input class="form-check-input"
               type="checkbox"
               name="is_featured"
               value="1"
               id="featuredCheck"
               {{ old('is_featured', $announcement?->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="featuredCheck">
            Tampilkan sebagai Featured
        </label>
    </div>
</div>

{{-- Photo --}}
<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file"
           name="photo"
           id="photoInput"
           class="form-control"
           accept="image/*">
    <div id="photoPreview" class="mt-2"
         style="{{ $announcement?->photo_path ? '' : 'display:none;' }}">
        <img id="photoPreviewImg"
             src="{{ $announcement?->photo_path ? asset('storage/'.$announcement->photo_path) : '#' }}"
             width="150"
             class="img-thumbnail">
    </div>
</div>

{{-- Attachment --}}
<div class="mb-3">
    <label class="form-label">Attachment <small class="text-muted">(opsional)</small></label>
    <input type="file" name="attachment" class="form-control">
    @if($announcement?->attachment_path)
        <small class="text-muted mt-1 d-block">
            File saat ini:
            <a href="{{ asset('storage/'.$announcement->attachment_path) }}" target="_blank">
                Lihat attachment
            </a>
            &mdash; upload file baru untuk mengganti.
        </small>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const startsAt = document.getElementById('starts_at');
    const endsAt   = document.getElementById('ends_at');

    startsAt.addEventListener('change', function () {
        endsAt.min = this.value;
        if (endsAt.value && endsAt.value < this.value) {
            endsAt.value = '';
        }
    });

    document.getElementById('photoInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('photoPreviewImg').src = e.target.result;
                document.getElementById('photoPreview').style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

});
</script>
@endpush
