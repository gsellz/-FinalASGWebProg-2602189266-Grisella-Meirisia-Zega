@extends('template')
@section('title', 'Search Result')

@section('content')
        <div class="row mt-4">
        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-11">
                    <input type="text" name="search" class="form-control" placeholder="Search by name"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>

    <h1>Search Results for "{{ $query }}"</h1>

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @foreach($users as $user)
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
    @endif
@endsection
