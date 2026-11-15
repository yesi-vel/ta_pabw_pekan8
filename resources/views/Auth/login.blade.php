@extends('layouts.app')
@section('title', 'Login - SiPustaka')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center fw-bold">Login SiPustaka</h4>
                
                @if($errors->any())
                    <div class="alert alert-danger py-2 small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
                </form>
                <div class="text-center mt-3 small">
                    Belum punya akun? <a href="{{ route('register') }}">Register di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection