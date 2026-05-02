<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f4ef;
            margin: 0;
        }

        .header {
            background: #1a1a18;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .header a {
            color: #c8753a;
            text-decoration: none;
            font-weight: 500;
        }

        .main {
            max-width: 1200px;
            margin: auto;
            padding: 40px;
        }

        .flash {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .flash.success { background: #d4edda; color: #155724; }
        .flash.error { background: #f8d7da; color: #721c24; }

        .section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.08);
        }

        .section h3 {
            margin-top: 0;
            color: #333;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.08);
        }

        .card-info h4 {
            margin: 0 0 5px 0;
        }

        .card-info p {
            margin: 2px 0;
        }

        .btn {
            padding: 8px 16px;
            background: #c8753a;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn:hover {
            background: #b06330;
        }

        .badge {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .pending { background: #fff3cd; color: #856404; }
        .confirmed { background: #d4edda; color: #155724; }
        .completed { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>

<div class="header">
    <h2>Welcome, {{ $guide->name }}</h2>
    <a href="/guide/logout">Logout</a>
</div>

<div class="main">

    <div class="section">
        <h3>Your Bookings ({{ $guide->bookings->count() }})</h3>

        @if($guide->bookings->isEmpty())
            <p>No bookings yet.</p>
        @else
            @foreach($guide->bookings as $booking)
                <div class="card">
                    <div class="card-info">
                        <h4>{{ $booking->guest_name }}</h4>
                        <p>Email: {{ $booking->guest_email }}</p>
                        <p>Date: {{ $booking->date ? $booking->date : 'Not specified' }}</p>
                        <p>Notes: {{ $booking->notes ?: 'None' }}</p>
                        <p>Status: <span class="badge {{ $booking->status }}">{{ ucfirst($booking->status) }}</span></p>
                        <p>Booked: {{ $booking->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        @if($booking->status === 'pending')
                            <a href="{{ route('guide.booking.confirm', $booking->id) }}" class="btn" style="background: #28a745; margin-right: 10px;">Confirm</a>
                            <a href="{{ route('guide.booking.cancel', $booking->id) }}" class="btn" style="background: #dc3545;">Cancel</a>
                        @elseif($booking->status === 'confirmed')
                            <a href="{{ route('guide.booking.complete', $booking->id) }}" class="btn" style="background: #17a2b8;">Mark Complete</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="section">
        <h3>Messages ({{ $guide->messages->count() }})</h3>

        @if($guide->messages->isEmpty())
            <p>No messages yet.</p>
        @else
            @foreach($guide->messages as $message)
                <div class="card">
                    <div class="card-info">
                        <h4>From: {{ $message->sender_name }} ({{ $message->guest_email }})</h4>
                        <p>{{ $message->message }}</p>
                        <p>Sent: {{ $message->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <a href="/guide/chat/{{ $message->guest_email }}" class="btn">Reply</a>
                </div>
            @endforeach
        @endif
    </div>

</div>

</body>
</html>