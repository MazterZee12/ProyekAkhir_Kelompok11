<div class="mb-3">
    <label>Type</label>
    <select name="type" class="form-control">
        <option value="ticket" {{ old('type',$price->type ?? '')=='ticket'?'selected':'' }}>Ticket</option>
        <option value="rental" {{ old('type',$price->type ?? '')=='rental'?'selected':'' }}>Rental</option>
    </select>
</div>

<div class="mb-3">
    <label>Amount</label>
    <input type="number" name="amount" class="form-control"
        value="{{ old('amount',$price->amount ?? '') }}">
</div>

<div class="mb-3">
    <label>Unit</label>
    <input type="text" name="unit" class="form-control"
        value="{{ old('unit',$price->unit ?? '') }}">
</div>

<div class="mb-3">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes',$price->notes ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Photo</label>
    <input type="file" name="photo" class="form-control">
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_active" class="form-check-input"
        {{ old('is_active',$price->is_active ?? false)?'checked':'' }}>
    <label class="form-check-label">Active</label>
</div>
