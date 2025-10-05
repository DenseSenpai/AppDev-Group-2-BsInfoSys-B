<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Boarder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /** 🟩 Show form to create account (Admin only) */
    public function create()
    {
        return view('accounts.create');
    }

    /** 🟩 Store a new account */
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

    /** 🟨 Edit account (Admin or owner only) */
    public function edit(User $user)
    {
        // ✅ Allow if admin OR editing own account
        if (auth()->id() !== $user->id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $boarder = $user->boarder;
        return view('accounts.edit', compact('user', 'boarder'));
    }

    /** 🟨 Update account (Admin or owner only) */
    public function update(Request $request, User $user)
    {
        // ✅ Allow if admin OR editing own account
        if (auth()->id() !== $user->id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'course'     => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:50',
        ]);

        // 1️⃣ Update user info
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // 2️⃣ Update boarder info if exists
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

        // ✅ Redirect student → dashboard; admin → boarders list
        if (auth()->user()->isAdmin()) {
            return redirect()->route('boarders.index')
                ->with('success', "Updated account + boarder for {$user->name}");
        } else {
            return redirect()->route('dashboard')
                ->with('success', "Your account has been updated successfully.");
        }
    }
}
