<div class="mb-3">
    <label>Rating</label>
    <select name="rating" class="form-control">
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}"
                {{ old('rating', $review->rating ?? '') == $i ? 'selected' : '' }}>
                {{ $i }} ★
            </option>
        @endfor
    </select>
</div>

<div class="mb-3">
    <label>Komentar</label>
    <textarea name="comment" class="form-control" rows="4">{{ old('comment', $review->comment ?? '') }}</textarea>
</div>
