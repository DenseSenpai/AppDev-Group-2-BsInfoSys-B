<x-app-layout>
    {{-- 🌇 Background Image --}}
    <div class="min-h-screen bg-cover bg-center bg-no-repeat relative" 
         style="background-image: url('https://plus.unsplash.com/premium_photo-1668800128586-381f0ac153fa?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">

        {{-- 🩶 Overlay for subtle readability --}}
        <div class="absolute inset-0 bg-white/70 backdrop-blur-sm"></div>

        <div class="relative z-10 container mx-auto p-6">
    <div class="container mx-auto p-6">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-10">

                    <!-- Rooms -->
                    <a href="{{ route('rooms.index') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-indigo-500 text-4xl mb-2">🏠</div>
                        <h2 class="font-bold text-lg">Rooms</h2>
                        <p class="text-sm text-gray-600">View and manage rooms.</p>
                    </a>

                    <!-- Boarders -->
                    <a href="{{ route('boarders.index') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-emerald-500 text-4xl mb-2">👥</div>
                        <h2 class="font-bold text-lg">Boarders</h2>
                        <p class="text-sm text-gray-600">View and manage boarders.</p>
                    </a>

                    <!-- Maintenance -->
                    <a href="{{ route('maintenance_reports.index') }}"
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-yellow-500 text-4xl mb-2">🧰</div>
                        <h2 class="font-bold text-lg">Maintenance</h2>
                        <p class="text-sm text-gray-600">View and manage maintenance requests.</p>
                    </a>

                    <!-- Payments -->
                    <a href="{{ route('payments.index') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-pink-500 text-4xl mb-2">💳</div>
                        <h2 class="font-bold text-lg">Payments</h2>
                        <p class="text-sm text-gray-600">View and manage payments.</p>
                    </a>

                    <!-- Create Account -->
                    <a href="{{ route('accounts.create') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-sky-500 text-4xl mb-2">➕</div>
                        <h2 class="font-bold text-lg">Account</h2>
                        <p class="text-sm text-gray-600">Create account for new boarders.</p>
                    </a>
                </div>
            @endif

            {{-- ✅ Student Dashboard --}}
            @if(auth()->user()->isStudent())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-10">

                    <!-- Rooms -->
                    <a href="{{ route('rooms.index') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-indigo-500 text-4xl mb-2">🛏️</div>
                        <h2 class="font-bold text-lg">Rooms</h2>
                        <p class="text-sm text-gray-600">Check your board mates.</p>
                    </a>

                    <!-- Report Issue -->
                    <a href="{{ route('maintenance_reports.index') }}"
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-yellow-500 text-4xl mb-2">🛠️</div>
                        <h2 class="font-bold">Report Issue</h2>
                        <p class="text-sm text-gray-600">Submit a maintenance request if there’s a problem in your room.</p>
                    </a>

                    <!-- Payments -->
                    <a href="{{ route('payments.index') }}" 
                       class="flex flex-col items-center justify-center p-6 bg-white rounded shadow hover:bg-gray-50 h-40">
                        <div class="text-pink-500 text-4xl mb-2">💰</div>
                        <h2 class="font-bold">Payments</h2>
                        <p class="text-sm text-gray-600">View and manage your boarding house bills.</p>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
