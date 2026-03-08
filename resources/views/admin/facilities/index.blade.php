@extends('layouts.admin')

@section('content')

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-4">
<h4>Facilities</h4>

<a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">
+ Add Facility
</a>
</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th width="60">#</th>
<th width="120">Photo</th>
<th>Name</th>
<th width="220">Action</th>
</tr>
</thead>

<tbody>

@forelse($facilities as $facility)

<tr>

<td>
{{ $facilities->firstItem() + $loop->index }}
</td>

<td>
@if($facility->photo_path)
<img src="{{ asset('storage/'.$facility->photo_path) }}" width="80" class="img-thumbnail">
@else
-
@endif
</td>

<td>
<strong>{{ $facility->name }}</strong>
</td>

<td class="d-flex gap-1">

<a href="{{ route('admin.facilities.edit',$facility->id) }}" class="btn btn-sm btn-warning">
Edit
</a>

<form action="{{ route('admin.facilities.destroy',$facility->id) }}" method="POST" onsubmit="return confirm('Delete this facility?')">

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
<td colspan="5" class="text-center">
No facilities found
</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">
{{ $facilities->links() }}
</div>

</div>
</div>

</div>

@endsection
