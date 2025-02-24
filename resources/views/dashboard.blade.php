<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1, h2 {
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 3px 4px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2e2e2;
        }

        button {
            padding: 6px 12px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #d32f2f;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        .logout-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .logout-btn:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container" style="margin:2%;">
        <div>
            <h2>Welcome to the Dashboard</h2>
            <p>Welcome, {{ session('user')['first_name'] }} {{ session('user')['last_name'] }}</p>
        </div>
        <div style="float: right;">
            
            <a class="logout-btn" href="{{ url('/logout') }}">Logout</a>
        </div>
        
        
        <!-- Authors Table -->
        <h2>Authors List</h2>

        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        @if(count($authors) > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Place of Birth</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                        <tr>
                            <td>{{ $author['id'] }}</td>
                            <td>{{ $author['first_name'] }}</td>
                            <td>{{ $author['last_name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($author['birthday'])->format('d M Y') }}</td>
                            <td>{{ $author['gender'] }}</td>
                            <td>{{ $author['place_of_birth'] }}</td>
                            <!-- <td>
                                <a href="{{ route('authors.show', $author['id']) }}">View</a> |
                                <form action="{{ route('authors.destroy', $author['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td> -->
                            <td>
                                <a href="{{ route('authors.show', $author['id']) }}">View</a> |
                                @if(!empty($author['delete_btn_active']) && $author['delete_btn_active'] == 'disabled') <!-- Check if delete button should be active -->
                                    <form action="{{ route('authors.destroy', $author['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                @else
                                    <!-- <button type="button" disabled>Delete</button>  -->
                                    <p style="font-size:9px;color:red;">Disabled delete button if there are books</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No authors available.</p>
        @endif

        <a href="{{ route('authors.create') }}">Add New Author</a>
    </div>
</body>
</html>
