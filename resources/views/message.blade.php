@extends('template')
@section('title', 'Messages')

@section('content')
    <h1>Messages</h1>

    <div class="messages">
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <p>
                    <strong>{{ $message->sender->name }}:</strong> <!-- Display sender's name -->
                    {{ $message->message }}
                </p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>

    <form action="{{ route('message.send', $userId) }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="message" class="form-control" placeholder="Type your message here" required>
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
@endsection
