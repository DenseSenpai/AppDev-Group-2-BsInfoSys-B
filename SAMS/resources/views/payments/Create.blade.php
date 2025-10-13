<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 mt-10 rounded-xl shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">➕ Create New Bill</h2>

        {{-- 🔴 Show validation errors if any --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            {{-- 🧍 Boarder Selection --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Select Boarder</label>
                <select name="boarder_id" class="w-full border rounded-lg p-2" required>
                    @foreach(\App\Models\Boarder::with('room')->get() as $boarder)
                        <option value="{{ $boarder->id }}">
                            {{ $boarder->first_name }} {{ $boarder->last_name }} 
                            — Room {{ $boarder->room->room_number ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 🧾 Bill Type --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Bill Type</label>
                <select name="type" class="w-full border rounded-lg p-2" required>
                    <option value="">-- Select Type --</option>
                    <option value="electricity">Electricity</option>
                    <option value="water">Water</option>
                    <option value="internet">Internet</option>
                    <option value="other">Other</option>
                </select>
            </div>

            {{-- 💰 Amount --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Amount (₱)</label>
                <input type="number" name="amount" step="0.01" min="0" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- 📅 Period Start --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Billing Period Start</label>
                <input type="date" name="period_start" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- 📅 Period End --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Billing Period End</label>
                <input type="date" name="period_end" class="w-full border rounded-lg p-2" required>
            </div>

            {{-- 💳 Payment Method --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Payment Method</label>
                <select name="payment_method" class="w-full border rounded-lg p-2">
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            {{-- 🟦 Buttons --}}
            <div class="flex items-center mt-6">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-black font-medium px-4 py-2 rounded-lg">
                    Create Bill
                </button>
                <a href="{{ route('payments.index') }}" 
                   class="ml-4 text-gray-600 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
