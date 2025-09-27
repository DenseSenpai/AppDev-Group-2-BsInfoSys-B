<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-white">Payments</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ Admin Dashboard --}}
        @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <p class="text-white mb-2">📌 Manage all student payments & bills here.</p>
            </div>

            {{-- 🔹 GCash Number Update Form --}}
            <div class="bg-white p-4 rounded shadow mb-6">
                <h3 class="text-lg font-bold mb-2">Update GCash Number</h3>
                <form action="{{ route('payments.updateGcash') }}" method="POST" class="flex space-x-2">
                    @csrf
                    <input type="text" name="gcash_number"
                           value="{{ \App\Models\Setting::where('key','gcash_number')->value('value') }}"
                           class="border rounded px-3 py-2 w-64">
                    <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">
                        Save
                    </button>
                </form>
            </div>
{{-- 🔹 Bills Table --}}
<h3 class="text-xl font-bold mb-2 text-white">Boarders & Payments</h3>
<table class="text-white table-auto w-full border-collapse border border-gray-300 mb-8">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Boarder</th>
            <th class="border p-2">Room</th>
            <th class="border p-2">Monthly Rent</th>
            <th class="border p-2">Bills</th>
        </tr>
    </thead>
    <tbody>
        @forelse($boarders as $boarder)
            <tr>
                <td class="border p-2">{{ $boarder->first_name }} {{ $boarder->last_name }}</td>
                <td class="border p-2">{{ $boarder->room->room_number ?? 'Not Assigned' }}</td>
                <td class="border p-2">
                    ₱{{ number_format($boarder->room->monthly_rent ?? 0, 2) }}
                </td>
                <td class="border p-2">
                    @forelse($boarder->bills as $bill)
                        <div class="mb-2">
                            <strong>{{ ucfirst($bill->type) }}</strong> - ₱{{ number_format($bill->amount, 2) }} <br>
                            Period: {{ $bill->period_start->format('M d, Y') }} - {{ $bill->period_end->format('M d, Y') }} <br>
                            Status: 
                            @if($bill->is_paid)
                                <span class="text-green-600 font-bold">Paid</span>
                            @else
                                <span class="text-red-600 font-bold">Unpaid</span>
                            @endif

                            {{-- Payments linked to this bill --}}
                            @foreach($bill->payments as $payment)
                                <div class="mt-1 text-sm text-gray-700">
                                    Method: {{ ucfirst($payment->method) }},
                                    Status: {{ ucfirst($payment->status) }},
                                    Paid At: {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : '-' }}
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <span class="text-gray-500">No bills yet</span>
                    @endforelse
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">No boarders yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $boarders->links() }}
</div>
        @endif

        {{-- ✅ Student Dashboard --}}
        @if(auth()->user()->isStudent())
            @php
                $myBoarder = auth()->user()->boarder;
                $gcashNumber = \App\Models\Setting::where('key','gcash_number')->value('value');
            @endphp

            @if($myBoarder)
                <div class="bg-white p-6 rounded shadow mb-4">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">My Bills & Payments</h3>
                    
                    <p class="text-gray-700 mb-4">
                        <strong>Room:</strong> {{ $myBoarder->room->room_number ?? 'Not assigned' }} <br>
                        <strong>Monthly Rent:</strong> ₱{{ number_format($myBoarder->room->monthly_rent ?? 0, 2) }}
                    </p>

                    <table class="w-full bg-gray-50 rounded shadow">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Bill Type</th>
                                <th class="p-2">Amount</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myBoarder->bills as $bill)
                                <tr class="border-t">
                                    <td class="p-2">{{ ucfirst($bill->type) }}</td>
                                    <td class="p-2">₱{{ number_format($bill->amount, 2) }}</td>
                                    <td class="p-2">
                                        @if($bill->is_paid)
                                            <span class="text-green-600 font-bold">Paid</span>
                                        @else
                                            <span class="text-red-600 font-bold">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        @if(!$bill->is_paid)
                                            {{-- Payment Options --}}
                                            <form action="{{ route('payments.checkout') }}" method="POST" class="flex space-x-2">
                                                @csrf
                                                <input type="hidden" name="boarder_id" value="{{ $myBoarder->id }}">
                                                <input type="hidden" name="amount" value="{{ $bill->amount }}">

                                                <select name="payment_method" class="border rounded px-2 py-1">
                                                    <option value="gcash">GCash</option>
                                                    <option value="cash">Cash</option>
                                                </select>

                                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">
                                                    Pay
                                                </button>
                                            </form>

                                            {{-- ✅ Show GCash Number --}}
                                            @if($gcashNumber)
                                                <p class="text-sm text-gray-600 mt-2">
                                                    💳 GCash Number: <strong>{{ $gcashNumber }}</strong>
                                                </p>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500">No bills yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-white">You are not registered as a boarder.</p>
            @endif
        @endif
    </div>
</x-app-layout>
