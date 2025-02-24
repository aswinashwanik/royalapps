<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 50px;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="datetime-local"] {
            font-family: Arial, sans-serif;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <h1>Add New Book</h1>

    <div class="form-container">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf

            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="author_id">Select Author:</label>
            <select name="author_id" id="author_id" required>
                @foreach($authors as $author)
                    <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                @endforeach
            </select>

            <label for="release_date">Release Date:</label>
            <input type="datetime-local" name="release_date" id="release_date" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>

            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn">

            <label for="format">Format:</label>
            <input type="text" name="format" id="format">

            <label for="number_of_pages">Number of Pages:</label>
            <input type="number" name="number_of_pages" id="number_of_pages">

            <button type="submit">Add Book</button>
        </form>
    </div>

    <a href="{{ route('authors.dashboard') }}">Back to Dashboard</a>

</body>
</html>
