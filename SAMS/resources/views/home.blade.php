<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 text-center px-4">
        <!-- Welcome Title -->
        <h1 class="text-4xl font-bold mb-4 text-gray-800 dark:text-gray-200">
            Welcome to Student Apartment Management
        </h1>

        <!-- Description -->
        <p class="mb-6 text-gray-700 dark:text-gray-300">
            Where you can manage your bills and ask for maintenance.
        </p>

        @auth
    <!-- For logged-in users -->
    <a href="{{ route('dashboard') }}" 
       class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
        Go to Dashboard
    </a>
@endauth

</x-app-layout>
