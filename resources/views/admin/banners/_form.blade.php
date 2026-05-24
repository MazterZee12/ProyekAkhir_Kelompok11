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
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $banner?->title ?? '') }}" required>
</div>

{{-- Subtitle --}}
<div class="mb-3">
    <label class="form-label">Subtitle</label>
    <input type="text" name="subtitle" class="form-control"
        value="{{ old('subtitle', $banner?->subtitle ?? '') }}">
</div>

{{-- URL --}}
<div class="mb-3">
    <label class="form-label">URL</label>
    <input type="url" name="url" class="form-control"
        value="{{ old('url', $banner?->url ?? '') }}">
    <small class="text-muted">Link when banner is clicked (optional)</small>
</div>

{{-- Image --}}
<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" id="imageInput"
        class="form-control" accept="image/*"
        {{ $banner ? '' : 'required' }}>
    <div id="imagePreview" class="mt-2"
        style="{{ $banner?->image_path ? '' : 'display:none;' }}">
        <img id="imagePreviewImg"
            src="{{ $banner?->image_path ? asset('storage/'.$banner->image_path) : '#' }}"
            width="200" class="img-thumbnail">
        @if($banner?->image_path)
            <small class="d-block text-muted mt-1">Upload foto baru untuk mengganti.</small>
        @endif
    </div>
</div>

{{-- Order --}}
<div class="mb-3">
    <label class="form-label">Order</label>
    <input type="number" name="order" class="form-control"
        value="{{ old('order', $banner?->order ?? 0) }}" min="0">
    <small class="text-muted">Smaller number appears first</small>
</div>

{{-- Active --}}
<div class="mb-3">
    <label class="form-label">Status</label>
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input"
            id="is_active" value="1"
            {{ old('is_active', $banner?->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('imageInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreviewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endpush
