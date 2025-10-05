<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Account</h2>

        {{-- ✅ Success message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ⚠ Validation errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <strong>There were some problems with your input:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 📝 Form --}}
        <form method="POST" action="{{ route('accounts.update', $user->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- User Info --}}
            <div>
                <label class="block font-medium text-gray-700">Full Name</label>
                <input type="text" name="name"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Email Address</label>
                <input type="email" name="email"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       value="{{ old('email', $user->email) }}" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" disabled>
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <small class="text-gray-500">⚠ Role cannot be changed here</small>
            </div>

            {{-- Boarder Info (only for students) --}}
            @if($user->role === 'student' && $boarder)
                <hr class="my-6 border-gray-300">
                <h4 class="text-xl font-semibold mb-4 text-gray-700">Boarder Information</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('first_name', $boarder->first_name) }}" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('last_name', $boarder->last_name) }}" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('phone', $boarder->phone) }}">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Course</label>
                        <input type="text" name="course"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('course', $boarder->course) }}">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Year Level</label>
                        <input type="text" name="year_level"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('year_level', $boarder->year_level) }}">
                    </div>
                </div>
            @endif

            {{-- Buttons --}}
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ auth()->user()->isAdmin() ? route('boarders.index') : route('dashboard') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700 transition">
                    Update Account
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
