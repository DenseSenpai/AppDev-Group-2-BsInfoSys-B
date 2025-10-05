<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center text-center px-4" 
         style="background-image: url('https://plus.unsplash.com/premium_photo-1667668221104-bedb32295205?q=80&w=1151&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
         
        <!-- Overlay for readability -->
        <div class="bg-black bg-opacity-60 w-full h-full absolute top-0 left-0"></div>

        <!-- Content Section -->
        <div class="relative z-10 max-w-2xl">
            <!-- Welcome Title -->
            <h1 class="text-4xl font-bold mb-4 text-black drop-shadow-lg">
                Welcome to Student Apartment Management
            </h1>

            <!-- Description -->
            <p class="mb-6 text-black text-lg">
                Where you can manage your bills and ask for maintenance.
            </p>

            @auth
                <!-- For logged-in users -->
                <a href="{{ route('dashboard') }}" 
                   class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Go to Dashboard
                </a>
            @endauth
        </div>
    </div>
</x-app-layout>
