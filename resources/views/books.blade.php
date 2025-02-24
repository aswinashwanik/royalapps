<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <label for="title">Book Title</label>
    <input type="text" name="title" id="title" required>

    <label for="author_id">Select Author</label>
    <select name="author_id" id="author_id" required>
        @foreach($authors as $author)
            <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
        @endforeach
    </select>

    <button type="submit">Add Book</button>
</form>
