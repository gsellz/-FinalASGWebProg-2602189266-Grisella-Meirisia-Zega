@extends('template')
@section('title', 'Friend Request')

@section('content')
    <h1>My Friend Request</h1>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
        @foreach ($friends as $user)
            <div class="card" style="width: 18rem;">
                <img src="#" class="card-img-top" alt="User Image">

                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <h5 class="card-title">{{ $user->sender_id }}</h5>
                    <p class="card-text">Gender: {{ $user->gender }}</p>
                    <p class="card-text">Hobbies:</p>
                    <ul>
                        @foreach (json_decode($user->hobbies, true) as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                    <form action="{{ route('friends-request.handle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sender_id" value="{{ $user->sender_id }}">
                        <input type="hidden" name="action" value="accept">
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>

                    <form action="{{ route('friends-request.handle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sender_id" value="{{ $user->sender_id }}">
                        <input type="hidden" name="action" value="reject">
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </form>


                </div>
            </div>
        @endforeach
    </div>

@endsection
