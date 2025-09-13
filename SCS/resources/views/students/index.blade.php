<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Students
            </h2>

            <!-- Big, clear Add Student button -->
            <a href="{{ route('students.create') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-black font-bold px-6 py-2 rounded shadow">
               ➕ Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Students Table -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">ID</th>
                            <th class="border px-4 py-2 text-left">Student No</th>
                            <th class="border px-4 py-2 text-left">First Name</th>
                            <th class="border px-4 py-2 text-left">Middle Name</th>
                            <th class="border px-4 py-2 text-left">Last Name</th>
                            <th class="border px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $student->id }}</td>
                                <td class="border px-4 py-2">{{ $student->studentno }}</td>
                                <td class="border px-4 py-2">{{ $student->firstname }}</td>
                                <td class="border px-4 py-2">{{ $student->middlename }}</td>
                                <td class="border px-4 py-2">{{ $student->lastname }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('students.edit', $student->id) }}"
                                       class="text-blue-600 hover:underline mr-2">Edit</a>

                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure you want to delete this student?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                    No students found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
