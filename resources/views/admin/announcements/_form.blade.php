@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="card">
<div class="card-body">

{{-- Title --}}
<div class="mb-3">
<label class="form-label">Title</label>
<input type="text"
       name="title"
       class="form-control"
       value="{{ old('title', $announcement->title ?? '') }}"
       required>
</div>

{{-- Content --}}
<div class="mb-3">
<label class="form-label">Content</label>
<textarea name="content"
          class="form-control"
          rows="5"
          required>{{ old('content', $announcement->content ?? '') }}</textarea>
</div>

{{-- Type --}}
<div class="mb-3">
<label class="form-label">Type</label>

<select name="type" class="form-control" required>

<option value="event"
{{ old('type', $announcement->type ?? '') == 'event' ? 'selected' : '' }}>
Event
</option>

<option value="promo"
{{ old('type', $announcement->type ?? '') == 'promo' ? 'selected' : '' }}>
Promo
</option>

<option value="info"
{{ old('type', $announcement->type ?? '') == 'info' ? 'selected' : '' }}>
Info
</option>

</select>
</div>

{{-- Start Date --}}
<div class="mb-3">
<label class="form-label">Start Date</label>

<input type="date"
       name="starts_at"
       class="form-control"
       value="{{ old('starts_at', isset($announcement) && $announcement->starts_at ? $announcement->starts_at->format('Y-m-d') : '') }}">
</div>

{{-- End Date --}}
<div class="mb-3">
<label class="form-label">End Date</label>

<input type="date"
       name="ends_at"
       class="form-control"
       value="{{ old('ends_at', isset($announcement) && $announcement->ends_at ? $announcement->ends_at->format('Y-m-d') : '') }}">
</div>

{{-- Publish Status --}}
<div class="mb-3">
<label class="form-label">Publish Status</label>

<div class="form-check">
<input class="form-check-input"
       type="checkbox"
       name="is_active"
       value="1"
       id="publishCheck"
       {{ old('is_active', $announcement->is_active ?? false) ? 'checked' : '' }}>

<label class="form-check-label" for="publishCheck">
Publish Announcement
</label>
</div>

<small class="text-muted">
Jika tidak dicentang maka announcement akan disimpan sebagai draft.
</small>

</div>

{{-- Photo --}}
<div class="mb-3">
<label class="form-label">Photo</label>

<input type="file"
       name="photo"
       class="form-control">

@if(isset($announcement) && $announcement->photo_path)
<div class="mt-2">
<img src="{{ asset('storage/'.$announcement->photo_path) }}"
     width="150"
     class="img-thumbnail">
</div>
@endif

</div>

{{-- Submit --}}
<div class="mt-4">
<button class="btn btn-primary">
Save
</button>

<a href="{{ route('admin.announcements.index') }}"
   class="btn btn-secondary">
Cancel
</a>
</div>

</div>
</div>
