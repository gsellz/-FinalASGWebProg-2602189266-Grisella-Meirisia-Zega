<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    @guest
        <!-- As a heading -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <h3>ConnectFriends</h3>
                </a>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <h3>ConnectFriends</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('user.homepage') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('search') }}">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('friends-request.index') }}">Friend request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('friends.index') }}">My Friends</a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Notifications <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-width" aria-labelledby="dropdownMenuButton1" style="width: 15vw;">
                        @forelse(Auth::user()->unreadNotifications as $notification)
                            <li>
                                <a class="dropdown-item dropdown-item-width"
                                    href="#" style="white-space: normal; word-wrap: break-word; word-break: break-word;">{{ $notification->data['message'] }}</a>
                            </li>
                        @empty
                            <li><a class="dropdown-item dropdown-item-width" href="#">No new notifications</a></li>
                        @endforelse
                    </ul>
                </div>


                <form action="{{ route('user.logout') }}" method="POST" class="d-inline ms-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </nav>
    @endguest

    <div class="container justify-content-center align-item-center mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
