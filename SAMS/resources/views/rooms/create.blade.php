<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-white">Add New Room</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="room_number" class="block text-white font-medium">Room Number</label>
                <input type="text" name="room_number" id="room_number" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('room_number') }}" required>
            </div>

            <div>
                <label for="type" class="block text-white font-medium">Room Type</label>
                <input type="text" name="type" id="type" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('type') }}">
            </div>

            <div>
                <label for="capacity" class="block text-white font-medium">Capacity</label>
                <input type="number" name="capacity" id="capacity" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('capacity') }}" min="1">
            </div>

            <div>
                <label for="monthly_rent" class="block text-white font-medium">Monthly Rent (₱)</label>
                <input type="number" name="monthly_rent" id="monthly_rent" 
                       class="w-full border rounded px-3 py-2" 
                       value="{{ old('monthly_rent') }}" step="0.01" required>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Room</button>
                <a href="{{ route('rooms.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
