<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boarder;
use App\Models\Room;
use App\Models\User;

class BoarderController extends Controller
{
    public function index()
    {
        $boarders = Boarder::with(['room', 'user'])->paginate(15);
        return view('boarders.index', compact('boarders'));
    }

    public function create()
    {
        $rooms = Room::all();
        $users = User::doesntHave('boarder')->get(); // ✅ only users not yet assigned
        return view('boarders.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:boarders,user_id',
            'boarder_id' => 'required|string|unique:boarders',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'course' => 'nullable|string',
            'year_level' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'nullable|date',
            'move_out_date' => 'nullable|date',
            'emergency_contacts' => 'nullable|array',
        ]);

        Boarder::create($data);

        return redirect()->route('boarders.index')->with('success','Boarder added.');
    }

    public function edit(Boarder $boarder)
    {
        $rooms = Room::all();
        $users = User::all();
        return view('boarders.edit', compact('boarder','rooms','users'));
    }

    public function update(Request $request, Boarder $boarder)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:boarders,user_id,' . $boarder->id,
            'boarder_id' => 'required|string|unique:boarders,boarder_id,'.$boarder->id,
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'course' => 'nullable|string',
            'year_level' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'nullable|date',
            'move_out_date' => 'nullable|date',
            'emergency_contacts' => 'nullable|array',
        ]);

        $boarder->update($data);

        return redirect()->route('boarders.index')->with('success','Boarder updated.');
    }

    public function destroy(Boarder $boarder)
    {
        $boarder->delete();
        return redirect()->route('boarders.index')->with('success','Boarder deleted.');
    }

}
