<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-white">Rooms</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ Admin Dashboard --}}
        @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <a href="{{ route('rooms.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ➕ Add New Room
                </a>
            </div>

            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">Room Number</th>
                        <th class="p-2">Type</th>
                        <th class="p-2">Capacity</th>
                        <th class="p-2">Occupancy</th>
                        <th class="p-2">Monthly Rent</th>
                        <th class="p-2">Availability</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr class="border-t">
                            <td class="p-2">{{ $room->room_number }}</td>
                            <td class="p-2">{{ $room->type }}</td>
                            <td class="p-2">{{ $room->capacity }}</td>
                            <td class="p-2">{{ $room->boarders->count() }} / {{ $room->capacity }}</td>
                            <td class="p-2">₱{{ number_format($room->monthly_rent, 2) }}</td>
                            <td class="p-2">
                                @if($room->is_available)
                                    <span class="text-green-600 font-bold">
                                        Available ({{ $room->available_slots }} left)
                                    </span>
                                @else
                                    <span class="text-red-600 font-bold">Full</span>
                                @endif
                            </td>
                            <td class="p-2">
                                <a href="{{ route('rooms.edit', $room) }}" class="text-blue-600">Edit</a> |
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600" onclick="return confirm('Delete this room?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Boarders & Management --}}
                        <tr>
                            <td colspan="7" class="bg-gray-50 p-3">
                                <strong>Boarders:</strong>
                                <ul class="ml-4 list-disc">
                                    @forelse($room->boarders as $boarder)
                                        <li class="mb-2">
                                            {{ $boarder->first_name }} {{ $boarder->last_name }} 
                                            (ID: {{ $boarder->boarder_id }})

                                            {{-- 🔹 Unassign Button --}}
                                            <form action="{{ route('rooms.unassignBoarder', [$room->id, $boarder->id]) }}" 
                                                  method="POST" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 text-sm" 
                                                        onclick="return confirm('Unassign this boarder?')">
                                                    Unassign
                                                </button>
                                            </form>

                                            {{-- 🔹 Transfer Dropdown --}}
                                            <form action="{{ route('rooms.transferBoarder', [$room->id, $boarder->id]) }}" 
                                                  method="POST" class="inline ml-2">
                                                @csrf
                                                <select name="new_room_id" class="border rounded px-2 py-1 text-sm">
                                                    @foreach($rooms as $otherRoom)
                                                        @if($otherRoom->id !== $room->id && $otherRoom->is_available)
                                                            <option value="{{ $otherRoom->id }}">
                                                                Room {{ $otherRoom->room_number }} 
                                                                ({{ $otherRoom->available_slots }} slots left)
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="bg-blue-600 text-black px-2 py-1 rounded text-sm">
                                                    Transfer
                                                </button>
                                            </form>
                                        </li>
                                    @empty
                                        <li>No boarders assigned</li>
                                    @endforelse
                                </ul>

                     {{-- ✅ Assign Student to Room --}}
<form action="{{ route('rooms.assignBoarder', $room->id) }}" method="POST" class="mt-3 flex space-x-2">
    @csrf
    <select name="user_id" class="border rounded px-2 py-1">
        @foreach(\App\Models\User::where('role', 'student')
            ->whereHas('boarder', function($query) {
                $query->whereNull('room_id'); // only boarders without a room
            })->get() as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
    </select>
    <button type="submit" class="bg-green-600 text-black px-3 py-1 rounded">
        Assign
    </button>
</form>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        @endif

        {{-- ✅ Student Dashboard --}}
        @if(auth()->user()->isStudent())
            @php
                $myBoarder = auth()->user()->boarder;
            @endphp

            @if($myBoarder && $myBoarder->room)
                <div class="bg-white p-6 rounded shadow mb-4">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">
                        Room {{ $myBoarder->room->room_number }} ({{ $myBoarder->room->type }})
                    </h3>

                    <p class="text-gray-700 mb-2">Capacity: {{ $myBoarder->room->capacity }}</p>
                    <p class="text-gray-700 mb-2">Occupancy: {{ $myBoarder->room->boarders->count() }} / {{ $myBoarder->room->capacity }}</p>
                    <p class="text-gray-700 mb-2">Monthly Rent: ₱{{ number_format($myBoarder->room->monthly_rent, 2) }}</p>

                    {{-- ✅ Student’s Unique Boarder ID --}}
                    <p class="text-gray-700 mb-4">
                        <strong>Your Unique ID:</strong> 
                        <span class="font-bold text-blue-600">{{ $myBoarder->boarder_id }}</span>
                    </p>

                    <h4 class="font-semibold text-gray-800">Your Bills:</h4>
                    <ul class="ml-4 list-disc text-gray-700">
                        @foreach($myBoarder->bills as $bill)
                            <li>
                                {{ ucfirst($bill->type) }} - ₱{{ number_format($bill->amount, 2) }}
                                ({{ $bill->is_paid ? 'Paid' : 'Unpaid' }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-white">You are not assigned to a room yet.</p>
            @endif
        @endif
    </div>
</x-app-layout>
