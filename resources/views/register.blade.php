@extends('template')
@section('title', 'Registration')

@section('content')
    <div class="row text-center mt-5">
        <h1>Register</h1>
    </div>
    <div class="row">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        <form action="{{ route('user.register') }}" method="POST">
            @csrf
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" name="name" class="form-control" id="name" autofocus required >
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                    required>
            </div>

            <!-- Hobbies -->
            <div class="mb-3">
                <label for="hobbies" class="form-label">Hobbies (Choose at least 3)</label>
                <div>
                    @php
                        $hobbies = [
                            'Reading',
                            'Travelling',
                            'Sports',
                            'Music',
                            'Gaming',
                            'Crafting',
                            'Editing',
                        ];
                    @endphp
                    @foreach ($hobbies as $hobby)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby }}"
                                id="hobby_{{ $hobby }}">
                            <label class="form-check-label" for="hobby_{{ $hobby }}">{{ $hobby }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <!-- Add more options if needed -->
                </select>
            </div>


            <!-- Instagram URL -->
            <div class="mb-3">
                <label for="instagram" class="form-label" >Instagram URL</label>
                <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" placeholder="http://www.instagram.com/username" id="instagram" required>
            </div>

            <!-- Mobile Phone -->
            <div class="mb-3">
                <label for="number" class="form-label">Mobile Phone</label>
                <input type="text" name="number" class="form-control" id="number" required>
                <div class="form-text">Must be all digits between 10 and 15 characters.</div>
            </div>

            <!-- Age -->
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" id="age" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
@endsection
