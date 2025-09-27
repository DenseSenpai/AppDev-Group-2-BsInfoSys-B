<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-white mb-4">Boarders List</h2>

        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Boarder ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Phone</th>
                    <th class="border px-4 py-2">Course</th>
                    <th class="border px-4 py-2">Year Level</th>
                    @if(auth()->user()->isAdmin())
                        <th class="border px-4 py-2">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($boarders as $boarder)
                    <tr>
                        <td class="border px-4 py-2">{{ $boarder->boarder_id }}</td>
                        <td class="border px-4 py-2">{{ $boarder->first_name }} {{ $boarder->last_name }}</td>
                        <td class="border px-4 py-2">{{ $boarder->email }}</td>
                        <td class="border px-4 py-2">{{ $boarder->phone }}</td>
                        <td class="border px-4 py-2">{{ $boarder->course }}</td>
                        <td class="border px-4 py-2">{{ $boarder->year_level }}</td>

                        @if(auth()->user()->isAdmin())
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('boarders.destroy', $boarder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this boarder?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
