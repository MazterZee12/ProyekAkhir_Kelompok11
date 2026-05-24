@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Address --}}
<div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" class="form-control"
        value="{{ old('address', $contact?->address ?? '') }}">
</div>

{{-- Email --}}
<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
        value="{{ old('email', $contact?->email ?? '') }}">
</div>

{{-- Phone --}}
<div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
        value="{{ old('phone', $contact?->phone ?? '') }}">
</div>

{{-- Google Maps Embed --}}
<div class="mb-3">
    <label class="form-label">Google Maps Embed</label>
    <textarea name="google_maps_embed" class="form-control" rows="4">{{ old('google_maps_embed', $contact?->google_maps_embed ?? '') }}</textarea>
    <small class="text-muted">Paste embed code from Google Maps</small>
</div>

{{-- Instagram --}}
<div class="mb-3">
    <label class="form-label">Instagram</label>
    <input type="text" name="instagram" class="form-control"
        value="{{ old('instagram', $contact?->instagram ?? '') }}">
</div>

{{-- Facebook --}}
<div class="mb-3">
    <label class="form-label">Facebook</label>
    <input type="text" name="facebook" class="form-control"
        value="{{ old('facebook', $contact?->facebook ?? '') }}">
</div>

{{-- YouTube --}}
<div class="mb-3">
    <label class="form-label">YouTube</label>
    <input type="text" name="youtube" class="form-control"
        value="{{ old('youtube', $contact?->youtube ?? '') }}">
</div>

{{-- Twitter --}}
<div class="mb-3">
    <label class="form-label">Twitter</label>
    <input type="text" name="twitter" class="form-control"
        value="{{ old('twitter', $contact?->twitter ?? '') }}">
</div>

{{-- Active --}}
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input"
            id="is_active" value="1"
            {{ old('is_active', $contact?->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
