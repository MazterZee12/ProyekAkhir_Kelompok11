@extends('layouts.auth')

@section('title','Login')

@section('content')
<div class="container" style="max-width:420px;margin-top:4rem;">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Admin Login</h5>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <div class="password-wrapper">

                        <input type="password" name="password" id="password" class="form-control" required>

                        <span class="toggle-password" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </span>

                    </div>

                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember" id="remember"> <label for="remember">Remember</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
