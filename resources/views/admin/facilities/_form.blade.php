@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- Name --}}
<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $facility?->name ?? '') }}" required>
</div>
{{-- Description --}}
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $facility?->description ?? '') }}</textarea>
</div>
{{-- Photo --}}
<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
    <div id="photoPreview" class="mt-2"
        style="{{ $facility?->media ? '' : 'display:none;' }}">
        <img id="photoPreviewImg"
            src="{{ $facility?->media?->url ?? '#' }}"
            width="150" class="img-thumbnail">
        @if($facility?->media)
            <small class="d-block text-muted mt-1">Upload foto baru untuk mengganti.</small>
        @endif
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
