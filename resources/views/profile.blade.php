{{ session('user.first_name') }} {{ session('user.last_name') }}
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
