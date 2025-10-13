<x-app-layout>
    <div class="min-h-screen bg-cover bg-center bg-no-repeat relative" 
         style="background-image: url('https://plus.unsplash.com/premium_photo-1668800128586-381f0ac153fa?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        
        {{-- 🌫️ Overlay for readability --}}
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <div class="container mx-auto p-6 relative z-10">
            <h2 class="text-2xl font-semibold mb-4 text-white text-center">💰 Payments</h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded mb-6 text-center font-medium shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Admin Dashboard --}}
            @if(auth()->user()->isAdmin())
                <div class="mb-4">
                    <p class="text-white mb-2 text-center text-lg font-medium">📌 Manage all student payments & bills here.</p>
                </div>

                {{-- 🔹 GCash Number Update Form --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg mb-8 max-w-xl mx-auto">
                    <h3 class="text-lg font-bold mb-3 text-gray-800">Update GCash Number</h3>
                    <form action="{{ route('payments.updateGcash') }}" method="POST" class="flex space-x-3">
                        @csrf
                        <input type="text" name="gcash_number"
                            value="{{ \App\Models\Setting::where('key','gcash_number')->value('value') }}"
                            class="border rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-5 py-2 rounded-lg shadow transition">
                            Save
                        </button>
                    </form>
                </div>

                {{-- 🔹 Bills Table --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-semibold text-white">🏠 Boarders & Payments</h3>

                    <a href="{{ route('payments.create') }}"
                       class="bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
                        ➕ Create Bill
                    </a>
                </div>

                <div class="overflow-x-auto bg-white bg-opacity-90 rounded-2xl shadow-lg p-4">
                    <table class="w-full border-collapse text-gray-800">
                        <thead class="bg-indigo-600 text-black">
                            <tr>
                                <th class="border p-3 text-left">Boarder</th>
                                <th class="border p-3 text-left">Room</th>
                                <th class="border p-3 text-left">Monthly Rent</th>
                                <th class="border p-3 text-left">Bills</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($boarders as $boarder)
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="border p-3">{{ $boarder->first_name }} {{ $boarder->last_name }}</td>
                                    <td class="border p-3">{{ $boarder->room->room_number ?? 'Not Assigned' }}</td>
                                    <td class="border p-3">₱{{ number_format($boarder->room->monthly_rent ?? 0, 2) }}</td>
                                    <td class="border p-3">
                                        {{-- ✅ Fixed bill loop --}}
                                        @forelse($boarder->bills as $bill)
                                            <div class="mb-3 p-3 bg-gray-50 rounded shadow-sm">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <strong>{{ ucfirst($bill->type) }}</strong> - ₱{{ number_format($bill->amount, 2) }} <br>
                                                        <span class="text-sm text-gray-600">Period:</span> 
                                                        {{ \Carbon\Carbon::parse($bill->period_start)->format('M d, Y') }} - 
                                                        {{ \Carbon\Carbon::parse($bill->period_end)->format('M d, Y') }} <br>
                                                        <span class="text-sm text-gray-600">Status:</span>
                                                        @if($bill->is_paid)
                                                            <span class="text-green-600 font-bold">Paid</span>
                                                        @else
                                                            <span class="text-red-600 font-bold">Unpaid</span>
                                                        @endif
                                                    </div>

                                                    {{-- 🗑️ Delete Button --}}
                                                    <form action="{{ route('payments.destroyBill', $bill->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded shadow">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>

                                                {{-- 💳 Payment details --}}
                                                @if($bill->payments && $bill->payments->count() > 0)
                                                    @foreach($bill->payments as $payment)
                                                        <div class="mt-2 text-sm text-gray-600 border-t pt-1">
                                                            Method: {{ ucfirst($payment->method) }},
                                                            Status: {{ ucfirst($payment->status) }},
                                                            Paid At: 
                                                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') : '-' }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @empty
                                            <span class="text-gray-500">No bills yet</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-600 p-4">No boarders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
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
                    <div class="bg-white bg-opacity-95 p-6 rounded-2xl shadow-xl mb-6">
                        <h3 class="text-2xl font-bold mb-3 text-gray-800">My Bills & Payments</h3>

                        <p class="text-gray-700 mb-4">
                            <strong>Room:</strong> {{ $myBoarder->room->room_number ?? 'Not assigned' }} <br>
                            <strong>Monthly Rent:</strong> ₱{{ number_format($myBoarder->room->monthly_rent ?? 0, 2) }}
                        </p>

                        <table class="w-full bg-gray-50 rounded-xl overflow-hidden">
                            <thead class="bg-indigo-600 text-black">
                                <tr>
                                    <th class="p-3 text-left">Bill Type</th>
                                    <th class="p-3 text-left">Amount</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myBoarder->bills as $bill)
                                    <tr class="border-t hover:bg-indigo-50 transition">
                                        <td class="p-3">{{ ucfirst($bill->type) }}</td>
                                        <td class="p-3">₱{{ number_format($bill->amount, 2) }}</td>
                                        <td class="p-3">
                                            @if($bill->is_paid)
                                                <span class="text-green-600 font-bold">Paid</span>
                                            @else
                                                <span class="text-red-600 font-bold">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            @if(!$bill->is_paid)
                                                <form action="{{ route('payments.checkout') }}" method="POST" class="flex space-x-2">
                                                    @csrf
                                                    <input type="hidden" name="boarder_id" value="{{ $myBoarder->id }}">
                                                    <input type="hidden" name="amount" value="{{ $bill->amount }}">

                                                    <select name="payment_method" class="border rounded px-2 py-1 focus:ring-2 focus:ring-indigo-400">
                                                        <option value="gcash">GCash</option>
                                                        <option value="cash">Cash</option>
                                                    </select>

                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow">
                                                        Pay
                                                    </button>
                                                </form>

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
                    <p class="text-black text-center text-lg">You are not registered as a boarder.</p>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
