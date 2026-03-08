@extends('layouts.admin')

@section('content')

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4>Gallery</h4>

<a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
+ Upload Gallery
</a>

</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th width="60">#</th>
<th width="120">Preview</th>
<th>Title</th>
<th width="120">Type</th>
<th width="150">Created</th>
<th width="220">Action</th>
</tr>
</thead>

<tbody>

@forelse($galleries as $gallery)

<tr>

<td>
{{ $galleries->firstItem() + $loop->index }}
</td>

<td>

@if($gallery->type == 'photo')

<img src="{{ $gallery->file_url }}" width="80" class="img-thumbnail">

@else

<video width="80">
<source src="{{ $gallery->file_url }}">
</video>

@endif

</td>

<td>
<strong>{{ $gallery->title ?? '-' }}</strong>
</td>

<td>
<span class="badge bg-info text-dark">
{{ ucfirst($gallery->type) }}
</span>
</td>

<td>
{{ $gallery->created_at->format('d M Y') }}
</td>

<td class="text-nowrap">

<a href="{{ route('admin.galleries.show', $gallery->id) }}"
class="btn btn-sm btn-info">
Show
</a>

<a href="{{ route('admin.galleries.edit', $gallery->id) }}"
class="btn btn-sm btn-warning">
Edit
</a>

<form action="{{ route('admin.galleries.destroy', $gallery->id) }}"
method="POST"
class="d-inline"
onsubmit="return confirm('Delete this gallery?')">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center">
No gallery found
</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">
{{ $galleries->links() }}
</div>

</div>
</div>

</div>

@endsection
