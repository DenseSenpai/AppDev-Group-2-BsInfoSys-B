<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\Boarder;
use App\Models\Setting;
use Carbon\Carbon;

class PaymentController extends Controller
{
   public function index()
{
    if (auth()->user()->isAdmin()) {
        // Load all boarders with their room and bills (eager load to prevent N+1)
        $boarders = \App\Models\Boarder::with(['room', 'bills.payments'])->paginate(10);

        return view('payments.index', compact('boarders'));
    }

    // Student view (already working)
    $myBoarder = auth()->user()->boarder;
    return view('payments.index', compact('myBoarder'));
}


   public function checkout(Request $request)
{
    $data = $request->validate([
        'boarder_id'     => 'required|exists:boarders,id',
        'amount'         => 'nullable|numeric',
        'payment_method' => 'required|string',
        'bill_id'        => 'nullable|exists:bills,id',
    ]);

    $boarder = Boarder::with('room')->findOrFail($data['boarder_id']);

    // ✅ If bill_id not provided, find unpaid rent bill or create one
    $bill = null;
    if (!empty($data['bill_id'])) {
        $bill = Bill::find($data['bill_id']);
    } else {
        $bill = Bill::firstOrCreate(
            [
                'boarder_id' => $boarder->id,
                'type'       => 'rent',
                'period_start' => now()->startOfMonth(),
                'period_end'   => now()->endOfMonth(),
            ],
            [
                'amount'            => $boarder->room->monthly_rent ?? 0,
                'is_auto_generated' => true,
                'is_paid'           => false,
            ]
        );
    }

    // ✅ Create payment (always tied to a bill)
    $payment = Payment::create([
        'boarder_id' => $boarder->id,
        'room_id'    => $boarder->room->id ?? null,
        'bill_id'    => $bill->id,
        'amount'     => $data['amount'] ?? $bill->amount,
        'method'     => $data['payment_method'],
        'status'     => 'completed',
        'paid_at'    => now(),
    ]);

    // ✅ Mark bill as paid
    $bill->update(['is_paid' => true]);

    return redirect()->route('payments.index')->with('success', 'Payment recorded.');
}


    public function update(Payment $payment)
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        if ($payment->bill) {
            $payment->bill->update(['is_paid' => true]);
        }

        return back()->with('success', 'Payment marked as paid.');
    }

    public function webhook(Request $request)
    {
        return response()->json(['status' => 'success']);
    }

    public function updateGcash(Request $request)
    {
        $request->validate(['gcash_number' => 'required|string']);
        Setting::updateOrCreate(
            ['key' => 'gcash_number'],
            ['value' => $request->gcash_number]
        );

        return back()->with('success', 'GCash number updated successfully!');
    }
}
