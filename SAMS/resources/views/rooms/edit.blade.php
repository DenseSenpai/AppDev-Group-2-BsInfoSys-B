<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-white">Edit Room</h2>

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

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="room_number" class="block text-white font-medium">Room Number</label>
                <input type="text" name="room_number" id="room_number"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('room_number', $room->room_number) }}" required>
            </div>

            <div>
                <label for="type" class="block text-white font-medium">Room Type</label>
                <input type="text" name="type" id="type"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('type', $room->type) }}">
            </div>

            <div>
                <label for="capacity" class="block text-white font-medium">Capacity</label>
                <input type="number" name="capacity" id="capacity"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('capacity', $room->capacity) }}" min="1">
            </div>

            <div>
                <label for="monthly_rent" class="block text-white font-medium">Monthly Rent (₱)</label>
                <input type="number" name="monthly_rent" id="monthly_rent"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('monthly_rent', $room->monthly_rent) }}" step="0.01" required>
            </div>

            <div>
                <label for="vacant_slots" class="block text-white font-medium">Vacant Slots</label>
                <input type="number" name="vacant_slots" id="vacant_slots"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('vacant_slots', $room->vacant_slots) }}"
                       min="0" max="{{ old('capacity', $room->capacity) }}">
                <p class="text-sm text-gray-300">Max: {{ $room->capacity }}</p>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Room</button>
                <a href="{{ route('rooms.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
