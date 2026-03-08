@extends('layouts.admin')

@section('title','Review Stats')

@section('content')

<div class="container-fluid">

<h1 class="mb-4">Review Statistics</h1>


<div class="row">

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>Total Reviews</h5>
<h2>{{ $total }}</h2>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>Average Rating</h5>
<h2>{{ $averageRating }}</h2>

</div>
</div>
</div>


<div class="col-md-2">
<div class="card text-center">
<div class="card-body">

<h6>Pending</h6>
<h3>{{ $pending }}</h3>

</div>
</div>
</div>


<div class="col-md-2">
<div class="card text-center">
<div class="card-body">

<h6>Hidden</h6>
<h3>{{ $hidden }}</h3>

</div>
</div>
</div>


<div class="col-md-2">
<div class="card text-center">
<div class="card-body">

<h6>Trashed</h6>
<h3>{{ $trashed }}</h3>

</div>
</div>
</div>


</div>


<div class="card mt-4">

<div class="card-header">
Rating Breakdown
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>Rating</th>
<th>Total</th>
</tr>
</thead>

<tbody>

@foreach($breakdown as $rating => $count)

<tr>
<td>{{ $rating }} Star</td>
<td>{{ $count }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection
