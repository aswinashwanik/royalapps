<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Author</title>
</head>
<body>
    <h1>Add New Author</h1>

    <form action="{{ route('authors.store') }}" method="POST" id="addAuthorForm">
        @csrf

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="birthday">Birthday (yyyy-mm-ddTHH:MM:SS.ZZZZ):</label>
        <input type="date" id="birthday" name="birthday" required><br>

        <label for="biography">Biography:</label>
        <textarea id="biography" name="biography" required></textarea><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>

        <label for="place_of_birth">Place of Birth:</label>
        <input type="text" id="place_of_birth" name="place_of_birth" required><br>

        <button type="submit">Add Author</button>
    </form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <!-- <script>
    // This will convert the datetime-local input into the correct ISO 8601 format with milliseconds and Z (UTC time)
    document.getElementById('addAuthorForm').addEventListener('submit', function (event) {
        const birthdayInput = document.getElementById('birthday');
        
        // Get the selected date from the datetime-local input
        const birthday = new Date(birthdayInput.value);

        // Ensure the date has been selected and properly formatted
        if (birthdayInput.value) {
            // Convert to ISO 8601 format with milliseconds and UTC (Z)
            const formattedBirthday = birthday.toISOString();  // Converts to ISO 8601 with milliseconds and Z
            birthdayInput.value = formattedBirthday;
        } else {
            alert("Please select a valid birthday.");
            event.preventDefault();  // Prevent form submission if no valid birthday is selected
        }
    });
</script> -->

</body>
</html>
