@extends('template')
@section('title', 'Homepage')

@section('content')
    <h1 class="mt-5">Hello, {{ $loggedInUserName }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex flex-wrap gap-3 justify-content-center">
        @foreach ($users as $user)
            <div class="card" style="width: 18rem;">
                <img src="https://img-cdn.pixlr.com/image-generator/history/65bb506dcb310754719cf81f/ede935de-1138-4f66-8ed7-44bd16efc709/medium.webp"
                    class="card-img-top" alt="User Image">

                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">Gender: {{ $user->gender }}</p>
                    <p class="card-text">Hobbies:</p>
                    <ul>
                        @foreach (json_decode($user->hobbies, true) as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                    <form action="{{ route('friends-request.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-primary">Thumbs Up!</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
