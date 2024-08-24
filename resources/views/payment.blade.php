@extends('template')
@section('title', 'Payment Process')
@section('content')
    <h1 class="mt-5">Payment</h1>


    @if ($message = Session::get('warning'))
        <div class="alert alert-warning">{{ $message }}</div>
    @endif

    @if ($message = Session::get('overpaid'))
        <div class="alert alert-warning">{{ $message }}</div>
        <form action="{{ route('user.payment.over') }}" method="POST">
            @csrf
            <button name="overpayment_action" value="balance" type="submit" class="btn btn-success">Yes</button>
            <button name="overpayment_action" value="retry" type="submit" class="btn btn-danger">No</button>
        </form>
    @else

        <h5>Registration price: Rp {{ number_format($registrationPrice) }}</h5>

        <form action="{{ route('user.payment.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="payment_amount" class="form-label">Enter your payment amount:</label>
                <input type="number" name="payment_amount" class="form-control" id="payment_amount" required
                    min="1">
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    @endif
    </div>

@endsection
