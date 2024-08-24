@extends('template')
@section('title', 'Friend List')
@section('content')
    <h1>My Friend List</h1>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
        @foreach ($friends as $user)
            <div class="card" style="width: 18rem;">
                <img src="#" class="card-img-top" alt="User Image">

                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">Gender: {{ $user->gender }}</p>
                    <p class="card-text">Hobbies:</p>
                    <ul>
                        @foreach (json_decode($user->hobbies, true) as $hobby)
                            <li>{{ $hobby }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>  

@endsection
