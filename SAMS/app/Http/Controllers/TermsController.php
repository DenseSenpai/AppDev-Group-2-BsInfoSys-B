<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function show()
    {
        return view('auth.terms');
    }

    public function accept(Request $request)
    {
        $user = $request->user();
        $user->terms_accepted = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Terms accepted successfully.');
    }
}
