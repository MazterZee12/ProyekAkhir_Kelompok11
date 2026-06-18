@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- Title --}}
<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $gallery?->title ?? '') }}">
</div>
{{-- Description --}}
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control"
        rows="4">{{ old('description', $gallery?->description ?? '') }}</textarea>
</div>
{{-- Upload --}}
<div class="mb-3">
    <label class="form-label">Upload Photo / Video</label>
    <input type="file" name="file" id="fileInput" class="form-control"
        accept="image/*,video/*">
    @if($gallery?->media)
        <div class="mt-2" id="oldPreview">
            @if($gallery->type == 'photo')
                <img src="{{ $gallery->media->url }}" width="150" class="img-thumbnail">
            @else
                <video width="200" controls>
                    <source src="{{ $gallery->media->url }}">
                </video>
            @endif
            <small class="d-block text-muted mt-1">Upload file baru untuk mengganti.</small>
        </div>
    @endif
    <div id="newPreview" class="mt-2" style="display:none;"></div>
</div>
{{-- Status --}}
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control">
        <option value="draft"     {{ old('status', $gallery?->status ?? 'draft') == 'draft'     ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $gallery?->status ?? 'draft') == 'published' ? 'selected' : '' }}>Published</option>
    </select>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('fileInput').addEventListener('change', function () {
        const file    = this.files[0];
        const preview = document.getElementById('newPreview');
        const old     = document.getElementById('oldPreview');
        if (!file) { preview.style.display = 'none'; return; }
        if (old) old.style.display = 'none';
        preview.style.display = 'block';
        preview.innerHTML = '';
        const url = URL.createObjectURL(file);
        if (file.type.startsWith('image/')) {
            preview.innerHTML = '<img src="' + url + '" width="150" class="img-thumbnail">';
        } else if (file.type.startsWith('video/')) {
            preview.innerHTML = '<video width="200" controls><source src="' + url + '"></video>';
        }
    });
});
</script>
@endpush
