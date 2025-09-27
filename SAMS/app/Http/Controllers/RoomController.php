<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Boarder;
use App\Models\User;

class RoomController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            // Admin → see all rooms with boarders + bills
            $rooms = Room::with(['boarders.bills'])->paginate(15);
        } else {
            // Student → see only their own room
            $boarder = auth()->user()->boarder; // relies on User ↔ Boarder relation
            $rooms = collect();

            if ($boarder && $boarder->room) {
                $rooms = collect([$boarder->room->load(['boarders.bills'])]);
            }
        }

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_number'   => 'required|string',
            'type'          => 'nullable|string',
            'capacity'      => 'required|integer|min:1',
            'monthly_rent'  => 'required|numeric',
            'vacant_slots'  => 'nullable|integer|min:0',
        ]);

        if (!isset($data['vacant_slots'])) {
            $data['vacant_slots'] = $data['capacity'];
        }

        if ($data['vacant_slots'] > $data['capacity']) {
            return back()->withErrors(['vacant_slots' => 'Vacant slots cannot exceed capacity'])->withInput();
        }

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Room created.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_number'   => 'required|string',
            'type'          => 'nullable|string',
            'capacity'      => 'required|integer|min:1',
            'monthly_rent'  => 'required|numeric',
            'vacant_slots'  => 'nullable|integer|min:0',
        ]);

        if (!isset($data['vacant_slots'])) {
            $data['vacant_slots'] = $room->vacant_slots ?? $data['capacity'];
        }

        if ($data['vacant_slots'] > $data['capacity']) {
            return back()->withErrors(['vacant_slots' => 'Vacant slots cannot exceed capacity'])->withInput();
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

   public function show(Room $room)
{
    $room->load('boarders');

    // ✅ Get all rooms for dropdown
    $rooms = Room::all();

    $unassignedBoarders = Boarder::whereNull('room_id')->get();

    return view('rooms.show', compact('room', 'rooms', 'unassignedBoarders'));
}


    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }

    /**
     * Assign a student (user) as a boarder in a room
     */
    public function assignBoarder(Request $request, Room $room)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $user = User::findOrFail($request->user_id);

    // If this user already has a boarder record, update it instead of creating duplicate
    $boarder = Boarder::firstOrNew(['user_id' => $user->id]);

    $boarder->fill([
        'boarder_id' => $boarder->boarder_id ?? strtoupper(uniqid('BID-')),
        'first_name' => $boarder->first_name ?? $user->name, // don’t overwrite if already set
        'last_name'  => $boarder->last_name ?? null,         // optional if you want to split later
        'email'      => $user->email,
        'room_id'    => $room->id,
    ]);

    $boarder->save();

    return back()->with(
        'success',
        "Assigned {$user->name} to Room {$room->room_number} (Boarder ID: {$boarder->boarder_id})"
    );
}

public function unassignBoarder(Room $room, Boarder $boarder)
{
    // Make sure the boarder is actually in this room
    if ($boarder->room_id !== $room->id) {
        return back()->withErrors(['boarder' => 'This boarder is not assigned to this room.']);
    }

    // Unassign (remove room_id)
    $boarder->update(['room_id' => null]);

    return back()->with(
        'success',
        "{$boarder->first_name} {$boarder->last_name} has been unassigned from Room {$room->room_number}."
    );
}
    
    public function transferBoarder(Request $request, Room $room, Boarder $boarder)
{
    $request->validate([
        'new_room_id' => 'required|exists:rooms,id',
    ]);

    $newRoom = Room::findOrFail($request->new_room_id);

    // Make sure the boarder belongs to the current room
    if ($boarder->room_id !== $room->id) {
        return back()->withErrors(['boarder' => 'This boarder is not assigned to this room.']);
    }

    // Transfer: update room_id
    $boarder->update(['room_id' => $newRoom->id]);

    return back()->with(
        'success',
        "{$boarder->first_name} {$boarder->last_name} has been transferred from Room {$room->room_number} to Room {$newRoom->room_number}."
    );
}


}
