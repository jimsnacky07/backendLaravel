@extends('partials.header')
<div class="container" style="max-width:400px; margin:40px auto;">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="mb-4 text-center">Login Admin</h3>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="mt-3 text-center">
                <a href="{{ route('register') }}">Belum punya akun? Register</a>
            </div>
        </div>
    </div>
</div>
@extends('partials.footer')