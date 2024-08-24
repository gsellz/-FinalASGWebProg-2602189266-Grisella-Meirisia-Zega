@extends('template')
@section('title', 'Payment Process')
@section('content')
    <div class="row mt-5">
        <h1>Login</h1>
    </div>
    <div class="row">
        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        @endif


        <form action="" method="POST">
            @csrf
            {{-- username --}}
            <div class="mb-3">
                <label for="name" class="form-label">Username </label>
                <input type="text" class="form-control" name="name" id="name" autofocus required>
            </div>

            {{-- password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Pasword</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Login</button>
        </form>
        {{-- Register link --}}
        <div class="mt-3">
            <p>Don't have an account? <a href="{{ route('user.register.show') }}">Register here</a>.</p>
        </div>

    </div>


@endsection
