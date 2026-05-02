<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Login</title>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f4ef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            width: 350px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #c8753a;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #b06330;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #c8753a;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>Guide Login</h2>

        @if(session('error'))
            <div style="color: red; margin-bottom: 15px; text-align: center;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/guide/login">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="links">
            <a href="{{ route('guides.apply') }}">Apply to be a Guide</a>
        </div>
    </div>
</body>
</html>