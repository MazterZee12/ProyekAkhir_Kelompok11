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
        value="{{ old('name', $profile?->name ?? '') }}" required>
</div>

{{-- Description --}}
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $profile?->description ?? '') }}</textarea>
</div>

{{-- History --}}
<div class="mb-3">
    <label class="form-label">History</label>
    <textarea name="history" class="form-control" rows="4">{{ old('history', $profile?->history ?? '') }}</textarea>
</div>

{{-- Vision --}}
<div class="mb-3">
    <label class="form-label">Vision</label>
    <textarea name="vision" class="form-control" rows="3">{{ old('vision', $profile?->vision ?? '') }}</textarea>
</div>

{{-- Mission --}}
<div class="mb-3">
    <label class="form-label">Mission</label>
    <textarea name="mission" class="form-control" rows="3">{{ old('mission', $profile?->mission ?? '') }}</textarea>
</div>

{{-- Established Year --}}
<div class="mb-3">
    <label class="form-label">Established Year</label>
    <input type="number" name="established_year" class="form-control"
        value="{{ old('established_year', $profile?->established_year ?? '') }}"
        min="1900" max="{{ date('Y') }}">
</div>

{{-- Regulations --}}
<div class="mb-3">
    <label class="form-label">Regulations</label>
    <textarea name="regulations" class="form-control" rows="4">{{ old('regulations', $profile?->regulations ?? '') }}</textarea>
</div>

{{-- Foto Pantai --}}
<div class="mb-3">
    <label class="form-label">Foto Pantai</label>
    <input type="file" name="photo_path" id="photoInput" class="form-control" accept="image/*">
    <div id="photoPreview" class="mt-2"
        style="{{ $profile?->photo_path ? '' : 'display:none;' }}">
        <img id="photoPreviewImg"
            src="{{ $profile?->photo_path ? asset('storage/'.$profile->photo_path) : '#' }}"
            width="120" class="img-thumbnail">
        @if($profile?->photo_path)
            <small class="d-block text-muted mt-1">Upload foto baru untuk mengganti.</small>
        @endif
    </div>
</div>

{{-- Active --}}
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
            {{ old('is_active', $profile?->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
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
