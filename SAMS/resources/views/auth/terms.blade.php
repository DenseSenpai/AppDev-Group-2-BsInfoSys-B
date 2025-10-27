<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 mt-20 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Terms and Conditions</h2>

        <p class="text-gray-700 mb-6">
            Welcome! Before using the system, please read and accept our Terms and Conditions.
        </p>

        <ul class="list-disc ml-6 text-gray-600 mb-6">
            <li>Respect privacy and data of others.</li>
            <li>Use the system responsibly.</li>
            <li>Your Personal Information is safe and secured</li>
            <li>Follow all boarding house policies.</li>
        </ul>

        {{-- ✅ Make sure this route matches your web.php --}}
        <form action="{{ route('terms.accept') }}" method="POST" class="text-center">
            @csrf
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-black px-6 py-2 rounded-lg">
                I Accept
            </button>
        </form>
    </div>
</x-app-layout>
