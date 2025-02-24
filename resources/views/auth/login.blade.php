<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
        }

        h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1em;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="email"], input[type="password"] {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .error-messages p {
            color: red;
            font-size: 0.9em;
            margin: 10px 0;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            font-size: 1.1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .forgot-password a {
            color: #4CAF50;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Login</h1>

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="error-messages">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Email Input -->
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
            </div>

            <!-- Password Input -->
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit">Login</button>
            </div>

            <div class="forgot-password">
                <a href="#">Forgot your password?</a>
            </div>
        </form>
    </div>

</body>
</html>
