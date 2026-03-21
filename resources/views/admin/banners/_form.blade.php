<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $banner->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Subtitle</label>
    <input type="text" name="subtitle" class="form-control"
        value="{{ old('subtitle', $banner->subtitle ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label">URL</label>
    <input type="url" name="url" class="form-control"
        value="{{ old('url', $banner->url ?? '') }}">
    <small class="text-muted">Link when banner is clicked (optional)</small>
</div>
<div class="mb-3">
    <label class="form-label">Image</label>
    @if(isset($banner) && $banner->image_path)
        <div class="mb-2">
            <img src="{{ asset('storage/'.$banner->image_path) }}" width="200" class="img-thumbnail">
        </div>
    @endif
    <input type="file" name="image" class="form-control" {{ isset($banner) ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label class="form-label">Order</label>
    <input type="number" name="order" class="form-control"
        value="{{ old('order', $banner->order ?? 0) }}" min="0">
    <small class="text-muted">Smaller number appears first</small>
</div>
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
            {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
