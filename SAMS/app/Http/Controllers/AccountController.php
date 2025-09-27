<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Boarder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function create()
    {
        return view('accounts.create'); // form for creating account
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'role'       => 'required|in:student,admin',
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'course'     => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:50',
        ]);

        // 1️⃣ Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // 2️⃣ If student → also create boarder record
        if ($request->role === 'student') {
            Boarder::create([
                'user_id'    => $user->id,
                'boarder_id' => strtoupper(uniqid('BID-')),
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'course'     => $request->course,
                'year_level' => $request->year_level,
            ]);
        }

        return redirect()->route('accounts.create')
            ->with('success', "Account for {$user->name} created successfully!");
    }

    public function edit(User $user)
    {
        $boarder = $user->boarder; // via relation
        return view('accounts.edit', compact('user', 'boarder'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'course'     => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:50',
        ]);

        // 1️⃣ Update User
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // 2️⃣ If boarder exists, update boarder info
        if ($user->boarder) {
            $user->boarder->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'course'     => $request->course,
                'year_level' => $request->year_level,
            ]);
        }

        return redirect()->route('boarders.index')
            ->with('success', "Updated account + boarder for {$user->name}");
    }
}
