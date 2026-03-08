@extends('layouts.admin')

@section('title','Reviews')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
    <h1>Reviews</h1>

    <a href="{{ route('admin.reviews.stats') }}" class="btn btn-info">
        Review Stats
    </a>
</div>


<form method="GET" class="mb-3">

<div class="row">

<div class="col-md-3">
<select name="status" class="form-control" onchange="this.form.submit()">

<option value="">All</option>
<option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
<option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
<option value="hidden" {{ request('status')=='hidden'?'selected':'' }}>Hidden</option>
<option value="trashed" {{ request('status')=='trashed'?'selected':'' }}>Trashed</option>

</select>
</div>

</div>

</form>


@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif


<div class="card">
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>User</th>
<th>Rating</th>
<th>Comment</th>
<th>Status</th>
<th width="220">Actions</th>
</tr>
</thead>

<tbody>

@foreach($reviews as $review)

<tr>

<td>{{ $review->id }}</td>

<td>{{ $review->user->name ?? '-' }}</td>

<td>{{ $review->rating }}</td>

<td>{{ $review->comment }}</td>

<td>

@if($review->deleted_at)
<span class="badge bg-danger">Trashed</span>

@elseif($review->hidden_at)
<span class="badge bg-warning">Hidden</span>

@elseif($review->approved)
<span class="badge bg-success">Approved</span>

@else
<span class="badge bg-secondary">Pending</span>
@endif

</td>

<td>

@if(!$review->deleted_at)

<a href="{{ route('admin.reviews.edit',$review) }}" class="btn btn-sm btn-primary">
Edit
</a>


<form action="{{ route('admin.reviews.toggleApproval',$review) }}"
method="POST"
style="display:inline">

@csrf

<button class="btn btn-sm btn-info">
Toggle
</button>

</form>


<form action="{{ route('admin.reviews.destroy',$review) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
Delete
</button>

</form>

@else

<form action="{{ route('admin.reviews.restore',$review->id) }}"
method="POST">

@csrf

<button class="btn btn-sm btn-success">
Restore
</button>

</form>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $reviews->links() }}

</div>
</div>

</div>

@endsection
