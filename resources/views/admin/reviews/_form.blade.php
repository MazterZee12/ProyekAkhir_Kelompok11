@csrf

<div class="mb-3">

<label>Rating</label>

<select name="rating" class="form-control">

@for($i=1;$i<=5;$i)

<option value="{{ $i }}"
{{ old('rating',$review->rating ?? '')==$i?'selected':'' }}>

{{ $i }}

</option>

@endfor

</select>

</div>



<div class="mb-3">

<label>Comment</label>

<textarea name="comment"
class="form-control"
rows="4">{{ old('comment',$review->comment ?? '') }}</textarea>

</div>



<div class="form-check mb-3">

<input type="checkbox"
name="approved"
class="form-check-input"
{{ old('approved',$review->approved ?? false)?'checked':'' }}>

<label class="form-check-label">
Approved
</label>

</div>
