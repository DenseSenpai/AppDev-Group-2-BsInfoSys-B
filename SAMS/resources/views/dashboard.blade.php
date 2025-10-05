<x-app-layout>
    {{-- 🌇 Background Image --}}
    <div class="relative min-h-screen bg-cover bg-center bg-no-repeat"
         style="background-image: url('https://plus.unsplash.com/premium_photo-1668800128586-381f0ac153fa?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0');">

        {{-- 🩶 White Overlay --}}
        <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>

        {{-- 🧱 Main Content --}}
        <div class="relative z-10 container mx-auto p-6">

            {{-- ✅ Welcome Message --}}
            @auth
                <div class="flex items-center justify-center mb-10">
                    <p class="text-black text-4xl sm:text-5xl lg:text-6xl font-bold text-center">
                        Welcome, <span class="text-black">{{ Auth::user()->name }}</span>!
                    </p>
                </div>
            @endauth

            {{-- ✅ Admin Dashboard --}}
            @if(auth()->user()->isAdmin())
                <div class="w-full px-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-10 place-items-center">
                        
                        <!-- Rooms -->
                        <a href="{{ route('rooms.index') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-indigo-500 text-4xl mb-2">🏠</div>
                            <h2 class="font-bold text-lg">Rooms</h2>
                            <p class="text-sm text-gray-600 text-center">View and manage rooms.</p>
                        </a>

                        <!-- Boarders -->
                        <a href="{{ route('boarders.index') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-emerald-500 text-4xl mb-2">👥</div>
                            <h2 class="font-bold text-lg">Boarders</h2>
                            <p class="text-sm text-gray-600 text-center">View and manage boarders.</p>
                        </a>

                        <!-- Maintenance -->
                        <a href="{{ route('maintenance_reports.index') }}"
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-yellow-500 text-4xl mb-2">🧰</div>
                            <h2 class="font-bold text-lg">Maintenance</h2>
                            <p class="text-sm text-gray-600 text-center">View maintenance reports.</p>
                        </a>

                        <!-- Payments -->
                        <a href="{{ route('payments.index') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-pink-500 text-4xl mb-2">💳</div>
                            <h2 class="font-bold text-lg">Payments</h2>
                            <p class="text-sm text-gray-600 text-center">View and manage payments.</p>
                        </a>

                        <!-- Create Account -->
                        <a href="{{ route('accounts.create') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-sky-500 text-4xl mb-2">➕</div>
                            <h2 class="font-bold text-lg">Account</h2>
                            <p class="text-sm text-gray-600 text-center">Create accounts for new boarders.</p>
                        </a>
                    </div>
                </div>
            @endif

            {{-- ✅ Student Dashboard --}}
            @if(auth()->user()->isStudent())
                <div class="w-full px-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-10 place-items-center">

                        <!-- Roommates -->
                        <a href="{{ route('rooms.index') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-indigo-500 text-4xl mb-2">🛏️</div>
                            <h2 class="font-bold text-lg">Rooms</h2>
                            <p class="text-sm text-gray-600 text-center">Check your roommates.</p>
                        </a>

                        <!-- Report Issue -->
                        <a href="{{ route('maintenance_reports.index') }}"
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-yellow-500 text-4xl mb-2">🛠️</div>
                            <h2 class="font-bold text-lg">Report Issue</h2>
                            <p class="text-sm text-gray-600 text-center">Submit maintenance requests.</p>
                        </a>

                        <!-- Payments -->
                        <a href="{{ route('payments.index') }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-pink-500 text-4xl mb-2">💰</div>
                            <h2 class="font-bold text-lg">Payments</h2>
                            <p class="text-sm text-gray-600 text-center">View your boarding house bills.</p>
                        </a>

                        <!-- Edit Account -->
                        <a href="{{ route('accounts.edit', Auth::user()->id) }}" 
                           class="w-64 flex flex-col items-center justify-center p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 h-40">
                            <div class="text-blue-500 text-4xl mb-2">✏️</div>
                            <h2 class="font-bold text-lg">Edit Account</h2>
                            <p class="text-sm text-gray-600 text-center">Update your course and year level.</p>
                        </a>

                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
