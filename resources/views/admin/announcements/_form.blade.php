@if ($errors->any())
    <div class="alert alert-danger js-alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text"
           name="title"
           class="form-control"
           value="{{ old('title', $announcement?->title ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content"
              class="form-control"
              rows="5"
              required>{{ old('content', $announcement?->content ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-control" required>
        <option value="event" {{ old('type', $announcement?->type ?? '') == 'event' ? 'selected' : '' }}>Event</option>
        <option value="promo" {{ old('type', $announcement?->type ?? '') == 'promo' ? 'selected' : '' }}>Promo</option>
        <option value="info"  {{ old('type', $announcement?->type ?? '') == 'info' ? 'selected' : '' }}>Info</option>
    </select>
</div>

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
    <small class="text-muted">Jika tidak dicentang maka announcement akan disimpan sebagai draft.</small>
</div>

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

<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file"
           name="photo"
           id="photoInput"
           class="form-control"
           accept="image/*">
    <div id="photoPreview" class="mt-2" style="{{ $announcement?->photo ? '' : 'display:none;' }}">
        <img id="photoPreviewImg"
             src="{{ $announcement?->photo ? $announcement->photo->url : '' }}"
             width="150"
             class="img-thumbnail"
             alt="Preview">
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewImg = document.getElementById('photoPreviewImg');

    if (photoInput && photoPreview && photoPreviewImg) {
        photoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreviewImg.src = e.target.result;
                    photoPreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endpush
