@extends('partials.header')
<div class="container" style="max-width:400px; margin:40px auto;">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="mb-4 text-center">Register Admin</h3>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>ID</label>
                    <input type="text" name="id" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Admin Level</label>
                    <input type="number" name="adminlevel" class="form-control" required min="1">
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Sudah punya akun? Login</a>
            </div>
        </div>
    </div>
</div>
@extends('partials.footer')