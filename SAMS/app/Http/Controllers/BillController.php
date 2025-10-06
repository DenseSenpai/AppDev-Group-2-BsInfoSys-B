<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Boarder;

class BillController extends Controller
{
    // 🟢 Show all bills / payment dashboard
    public function index()
    {
        // Load all boarders with their rooms and bills
        $boarders = Boarder::with(['room', 'bills.payments'])->paginate(10);

        return view('payments.index', compact('boarders'));
    }

    // 🟩 Show form for creating new bill
    public function create()
    {
        $boarders = Boarder::with('room')->get();
        return view('payments.create', compact('boarders'));
    }

    // 🟩 Store new bill
    public function store(Request $request)
    {
        $request->validate([
            'boarder_id' => 'required|exists:boarders,id',
            'type' => 'required|string|in:electricity,water,internet,other',
            'amount' => 'required|numeric|min:0',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        Bill::create([
            'boarder_id' => $request->boarder_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'is_auto_generated' => false,
            'is_paid' => false,
        ]);

        return redirect()->route('payments.index')->with('success', 'Bill created successfully!');
    }
}
