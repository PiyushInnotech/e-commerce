<p>This is dashboard page {{ auth()->user()->email }}</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
        Log Out
    </button>
</form>