<x-app-layout>
    <div class="min-h-screen w-full overflow-x-hidden">
    {{-- 🌇 Background Image --}}
    <div class="relative min-h-screen bg-cover bg-center bg-no-repeat"
         style="background-image: url('https://plus.unsplash.com/premium_photo-1668800128586-381f0ac153fa?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0');">

        {{-- 🩶 White Overlay --}}
        <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>

        {{-- 🧱 Main Content --}}
        <div class="relative z-10 container mx-auto p-6">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Create New Account</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('accounts.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
    <label class="block font-bold mb-1">Full Name</label>
    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div class="mb-4">
    <label class="block font-bold mb-1">First Name</label>
    <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div class="mb-4">
    <label class="block font-bold mb-1">Last Name</label>
    <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded px-3 py-2" required>
</div>



            {{-- Email --}}
            <div class="mb-4">
                <label class="block font-bold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block font-bold mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label class="block font-bold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block font-bold mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
