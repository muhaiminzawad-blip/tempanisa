<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Guest</title>
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
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }

        .chat-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.08);
            height: 600px;
            display: flex;
            flex-direction: column;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }

        .message.user {
            background: #e3f2fd;
            margin-left: 20%;
        }

        .message.guide {
            background: #f3e5f5;
            margin-right: 20%;
        }

        .message-meta {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .chat-form {
            display: flex;
            gap: 10px;
        }

        .chat-form input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .chat-form button {
            padding: 12px 20px;
            background: #c8753a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .chat-form button:hover {
            background: #b06330;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Chat with Guest ({{ $email }})</h2>
    <a href="/guide/dashboard">Back to Dashboard</a>
</div>

<div class="main">
    <div class="chat-container">
        @if(session('success'))
            <div class="flash success" style="margin-bottom: 16px; padding: 12px; border-radius: 8px; background: #d4edda; color: #155724;">
                {{ session('success') }}
            </div>
        @endif
        <div class="chat-messages" id="chat-messages">
            @foreach($messages as $message)
                <div class="message {{ $message->sender_type }}">
                    <div class="message-meta">
                        {{ $message->sender_name }} - {{ $message->created_at->format('M d, H:i') }}
                    </div>
                    {{ $message->message }}
                </div>
            @endforeach
        </div>

        <form class="chat-form" method="POST" action="/guides/{{ $guide->id }}/messages">
            @csrf
            <input type="hidden" name="sender_name" value="{{ $guide->name }}">
            <input type="hidden" name="receiver_name" value="Guest">
            <input type="hidden" name="sender_type" value="guide">
            <input type="hidden" name="guest_email" value="{{ $email }}">
            <input type="text" name="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

<script>
// Auto scroll to bottom of chat
document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;

// Optional: Auto refresh messages every 5 seconds
setInterval(function() {
    // Could add AJAX to refresh messages, but for now just scroll
}, 5000);
</script>

</body>
</html>