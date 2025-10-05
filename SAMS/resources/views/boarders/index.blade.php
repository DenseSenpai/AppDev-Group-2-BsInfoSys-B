<x-app-layout>
    <div class="min-h-screen bg-cover bg-center bg-no-repeat relative" 
         style="background-image: url('https://plus.unsplash.com/premium_photo-1668800128586-381f0ac153fa?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        
        {{-- 🌫️ Overlay for readability --}}
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        
        <div class="container mx-auto px-6">
            {{-- 🏡 Header --}}
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-indigo-800 tracking-wide mb-2">
                    🏡 Boarders List
                </h2>
                <p class="text-gray-600 text-lg">A complete list of all registered boarders</p>
                <div class="mt-3 mx-auto w-24 h-1 bg-indigo-500 rounded-full"></div>
            </div>

            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-8 shadow-md text-center font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 🧑‍🎓 Boarder Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($boarders as $boarder)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition duration-300 overflow-hidden">
                        <div class="bg-indigo-600 text-black p-4 text-center">
                            <h3 class="text-xl font-bold">{{ $boarder->first_name }} {{ $boarder->last_name }}</h3>
                            <p class="text-sm opacity-80">{{ $boarder->course }} • {{ $boarder->year_level }}</p>
                        </div>

                        <div class="p-6 space-y-3">
                            <p class="text-gray-700"><span class="font-semibold">Boarder ID:</span> {{ $boarder->boarder_id }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ $boarder->email }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Phone:</span> {{ $boarder->phone }}</p>
                        </div>

                        @if(auth()->user()->isAdmin())
                            <div class="p-4 text-center border-t bg-gray-50">
                                <form action="{{ route('boarders.destroy', $boarder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this boarder?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-black font-semibold px-5 py-2 rounded-lg shadow-sm transition duration-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- If there are no boarders --}}
            @if($boarders->isEmpty())
                <div class="text-center text-gray-500 mt-10">
                    <p class="text-lg">No boarders found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
