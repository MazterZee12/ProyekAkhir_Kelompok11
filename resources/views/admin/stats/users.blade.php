@extends('layouts.admin')

@section('title','User Statistics')

@section('content')

<div class="container-fluid">

<h1 class="mb-4">User Statistics</h1>

<div class="row">

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>Total Users</h5>
<h2>{{ $totalUsers }}</h2>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>Admins</h5>
<h2>{{ $adminUsers }}</h2>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>Regular Users</h5>
<h2>{{ $regularUsers }}</h2>

</div>
</div>
</div>


<div class="col-md-3">
<div class="card text-center">
<div class="card-body">

<h5>New This Month</h5>
<h2>{{ $newUsers }}</h2>

</div>
</div>
</div>

</div>

</div>

@endsection
