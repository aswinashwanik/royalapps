<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author['first_name'] }} {{ $author['last_name'] }} Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 2.5em;
        }

        p {
            font-size: 1.1em;
        }

        .container {
            padding: 20px;
            margin: 0 auto;
            max-width: 900px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            margin-top: 0;
            font-size: 2em;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c0392b;
        }

        a {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 1em;
        }

        a:hover {
            background-color: #2980b9;
        }

        .actions {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>{{ $author['first_name'] }} {{ $author['last_name'] }}</h1>
</header>

<div class="container">
    <p><strong>Birthday:</strong> {{ $author['birthday'] }}</p>
    <p><strong>Place of Birth:</strong> {{ $author['place_of_birth'] }}</p>

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

    <div class="actions">
        <a href="{{ route('books.create') }}">Add New Book</a>
        <a href="{{ route('authors.dashboard') }}">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
