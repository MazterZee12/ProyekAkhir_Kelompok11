@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Prices</h4>

    <a href="{{ route('admin.prices.create') }}" class="btn btn-primary">
        + Add Price
    </a>
</div>

<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Photo</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Unit</th>
    <th>Status</th>
    <th width="180">Action</th>
</tr>
</thead>

<tbody>
@foreach($prices as $price)
<tr>
<td>{{ $price->id }}</td>

<td>
@if($price->photo_path)
<img src="{{ asset('storage/'.$price->photo_path) }}" width="80">
@endif
</td>

<td>{{ ucfirst($price->type) }}</td>

<td>{{ $price->formatted_amount }}</td>

<td>{{ $price->unit }}</td>

<td>
@if($price->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-secondary">Inactive</span>
@endif
</td>

<td>

<a href="{{ route('admin.prices.show',$price) }}" class="btn btn-info btn-sm">
View
</a>

<a href="{{ route('admin.prices.edit',$price) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.prices.destroy',$price) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button onclick="return confirm('Delete this data?')"
class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>
</tr>
@endforeach
</tbody>
</table>

{{ $prices->links() }}

@endsection
