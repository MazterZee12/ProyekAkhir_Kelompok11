@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Type --}}
<div class="mb-3">
    <label class="form-label">Type</label>
    <select name="type" class="form-control">
        <option value="ticket" {{ old('type', $price?->type ?? '') == 'ticket' ? 'selected' : '' }}>Ticket</option>
        <option value="rental" {{ old('type', $price?->type ?? '') == 'rental' ? 'selected' : '' }}>Rental</option>
    </select>
</div>

{{-- Amount --}}
<div class="mb-3">
    <label class="form-label">Amount</label>
    <input type="number" name="amount" class="form-control"
        value="{{ old('amount', $price?->amount ?? '') }}">
</div>

{{-- Unit --}}
<div class="mb-3">
    <label class="form-label">Unit</label>
    <input type="text" name="unit" class="form-control"
        value="{{ old('unit', $price?->unit ?? '') }}">
</div>

{{-- Notes --}}
<div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $price?->notes ?? '') }}</textarea>
</div>

{{-- Photo --}}
<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
    <div id="photoPreview" class="mt-2"
        style="{{ $price?->photo_path ? '' : 'display:none;' }}">
        <img id="photoPreviewImg"
            src="{{ $price?->photo_path ? asset('storage/'.$price->photo_path) : '#' }}"
            width="150" class="img-thumbnail">
        @if($price?->photo_path)
            <small class="d-block text-muted mt-1">Upload foto baru untuk mengganti.</small>
        @endif
    </div>
</div>

{{-- Active --}}
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
            {{ old('is_active', $price?->is_active ?? false) ? 'checked' : '' }}>
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
