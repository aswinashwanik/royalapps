<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors List</title>
</head>
<body>
    <h1>Authors</h1>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birthday</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author['first_name'] }}</td>
                    <td>{{ $author['last_name'] }}</td>
                    <td>{{ $author['birthday'] }}</td>
                    <td>
                        <a href="{{ route('authors.show', $author['id']) }}">View</a>
                        <form action="{{ route('authors.destroy', $author['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
