@extends('layouts.admin')
@section('content')
<h4>Price Detail</h4>
<div class="card">
<div class="card-body">
@if($price->media)
<img src="{{ $price->media->url }}"
width="300"
class="mb-3">
@endif
<p><b>Type :</b> {{ ucfirst($price->type) }}</p>
<p><b>Amount :</b> {{ $price->formatted_amount }}</p>
<p><b>Unit :</b> {{ $price->unit }}</p>
<p><b>Notes :</b> {{ $price->notes }}</p>
<p>
<b>Status :</b>
@if($price->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-secondary">Inactive</span>
@endif
</p>
</div>
</div>
<a href="{{ route('admin.prices.index') }}"
class="btn btn-secondary mt-3">
Back
</a>
@endsection
