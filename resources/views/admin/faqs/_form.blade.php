<div class="mb-3">
    <label class="form-label">Question</label>
    <input type="text" name="question" class="form-control"
        value="{{ old('question', $faq?->question ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Answer</label>
    <textarea name="answer" class="form-control" rows="4">{{ old('answer', $faq?->answer ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Order</label>
    <input type="number" name="order" class="form-control"
        value="{{ old('order', $faq?->order ?? 0) }}" min="0">
    <small class="text-muted">Smaller number appears first</small>
</div>
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
            {{ old('is_active', $faq?->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
