<form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit">Logout</button>
</form>