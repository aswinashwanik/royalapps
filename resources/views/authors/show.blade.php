<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author['first_name'] }} {{ $author['last_name'] }} Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            /* padding: 1px 0; */
        }
        h1 {
            font-size: 2.5em;
            margin: 0;
        }
        h2 {
            font-size: 1.8em;
            color: #333;
            margin-top: 30px;
        }
        p {
            font-size: 1.1em;
            margin: 5px 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #ffffff;
            margin: 10px 0;
            padding: 3px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #d32f2f;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #45a049;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .author-info {
            margin-bottom: 30px;
            padding: 4px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h3>{{ $author['first_name'] }} {{ $author['last_name'] }} - Books</h3>
        </header>

        <div class="author-info">
            <p><strong>Birthday:</strong> {{ $author['birthday'] }}</p>
            <p><strong>Biography:</strong> {{ $author['biography'] }}</p>
            <p><strong>Place of Birth:</strong> {{ $author['place_of_birth'] }}</p>
        </div>

        <h2>Books</h2>
        <ul>
            @foreach($author['books'] as $book)
                <li>
                    <span>{{ $book['title'] }}</span>
                    <form method="POST" action="{{ route('books.destroy', $book['id']) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('books.create') }}">Add New Book</a>
        <a href="{{ route('authors.dashboard') }}">Back to Dashboard</a>
    </div>
</body>
</html>
