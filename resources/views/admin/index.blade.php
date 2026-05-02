<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            max-width: 1100px;
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

        .room-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.08);
        }

        .room-info h4 {
            margin: 0 0 5px 0;
        }

        .room-info p {
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
    </style>
</head>
<body>

<div class="header">
    <h2>Admin Dashboard</h2>
    <div class="flex space-x-4">
        <a href="/admin/guides" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Manage Guides</a>
        <a href="/admin/logout">Logout</a>
    </div>
</div>

<div class="main">

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <h3>Room Requests ({{ count($requests) }})</h3>

    @forelse($requests as $room)
        <div class="room-card">
            <div class="room-info">
                <h4>{{ $room->name }}</h4>
                <p>Price: ৳ {{ $room->price }}</p>
                <p>Status: <strong>{{ ucfirst($room->status) }}</strong></p>
            </div>
            <a href="/admin/room/{{ $room->id }}" class="btn">View</a>
        </div>
    @empty
        <p>No room requests found.</p>
    @endforelse

</div>

</body>
</html>