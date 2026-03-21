<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $profile->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $profile->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">History</label>
    <textarea name="history" class="form-control" rows="4">{{ old('history', $profile->history ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Vision</label>
    <textarea name="vision" class="form-control" rows="3">{{ old('vision', $profile->vision ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Mission</label>
    <textarea name="mission" class="form-control" rows="3">{{ old('mission', $profile->mission ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Established Year</label>
    <input type="number" name="established_year" class="form-control"
        value="{{ old('established_year', $profile->established_year ?? '') }}"
        min="1900" max="{{ date('Y') }}">
</div>
<div class="mb-3">
    <label class="form-label">Regulations</label>
    <textarea name="regulations" class="form-control" rows="4">{{ old('regulations', $profile->regulations ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Logo</label>
    @if(isset($profile) && $profile->logo_path)
        <div class="mb-2">
            <img src="{{ asset('storage/'.$profile->logo_path) }}" width="120" class="img-thumbnail">
        </div>
    @endif
    <input type="file" name="logo_path" class="form-control">
</div>
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
            {{ old('is_active', $profile->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
