<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <!-- Email -->
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <!-- Password -->
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</x-guest-layout>
