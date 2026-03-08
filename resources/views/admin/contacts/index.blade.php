@extends('layouts.admin')

@section('content')

<div class="container">

<h4 class="mb-4">Contact Settings</h4>

<div class="card">
<div class="card-body">

<form action="{{ route('admin.contacts.update') }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Address</label>
<textarea name="address" class="form-control">{{ old('address',$contact->address) }}</textarea>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control"
value="{{ old('email',$contact->email) }}">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control"
value="{{ old('phone',$contact->phone) }}">
</div>

<div class="mb-3">
<label>Instagram</label>
<input type="text" name="instagram" class="form-control"
value="{{ old('instagram',$contact->instagram) }}">
</div>

<div class="mb-3">
<label>Facebook</label>
<input type="text" name="facebook" class="form-control"
value="{{ old('facebook',$contact->facebook) }}">
</div>

<div class="mb-3">
<label>Twitter</label>
<input type="text" name="twitter" class="form-control"
value="{{ old('twitter',$contact->twitter) }}">
</div>

<div class="mb-3">
<label>Google Maps Embed</label>
<textarea name="google_maps_embed" class="form-control">{{ old('google_maps_embed',$contact->google_maps_embed) }}</textarea>
</div>

<div class="form-check mb-3">
<input class="form-check-input"
       type="checkbox"
       name="is_active"
       value="1"
       {{ old('is_active',$contact->is_active ?? true) ? 'checked' : '' }}>

<label class="form-check-label">
Active Contact Information
</label>
</div>

<button class="btn btn-primary">
Save Contact
</button>

</form>

</div>
</div>

</div>

@endsection
