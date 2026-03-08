<div class="mb-3">
    <label>Category</label>
    <select name="category_id" class="form-control">
        <option value="">-- Select Category --</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ old('category_id', $facility->category_id ?? '') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $facility->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $facility->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Photo</label>
    <input type="file" name="photo" class="form-control">
</div>
