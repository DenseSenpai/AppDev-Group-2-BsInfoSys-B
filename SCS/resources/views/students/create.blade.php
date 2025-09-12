<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Student
            </h2>

            <!-- Back Button -->
            <a href="{{ route('students.index') }}"
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold px-6 py-2 rounded shadow">
               ← Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Show Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Add Student Form -->
            <form action="{{ route('students.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Student No:</label>
                    <input type="text" name="studentno" value="{{ old('studentno') }}"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">First Name:</label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Middle Name:</label>
                    <input type="text" name="middlename" value="{{ old('middlename') }}"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Last Name:</label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}"
                           class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded shadow">
                        ✅ Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
