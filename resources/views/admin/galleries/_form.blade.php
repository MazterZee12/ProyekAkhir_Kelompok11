@csrf

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text"
        name="title"
        class="form-control"
        value="{{ old('title', $gallery->title ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea
        name="description"
        class="form-control"
        rows="4">{{ old('description', $gallery->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Upload Photo / Video</label>
    <input type="file"
        name="file"
        class="form-control">
</div>

@if(isset($gallery) && $gallery->file_url)
<div class="mb-3">

<label class="form-label">Current File</label>

<div>

@if($gallery->type == 'photo')
<img src="{{ $gallery->file_url }}" width="150" class="img-thumbnail">
@else
<video width="200" controls>
<source src="{{ $gallery->file_url }}">
</video>
@endif

</div>

</div>
@endif
