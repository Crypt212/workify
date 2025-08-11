<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-9 py-4 flex justify-between items-center">
        <!-- Left side - Logo/Brand -->
        <div class="flex-shrink-0">
            <a href="/">
                <span class="h-8 w-auto"> WORKIFY </span>
            </a>
        </div>

        <!-- Right side - User info and buttons -->
        <div class="flex items-center space-x-4">
            <!-- User information -->
            <div class="text-right mr-4">
                <div class="font-medium text-gray-900">
                    {{ auth()->user()->name }}
                    <span class="text-gray-500 text-sm">({{ auth()->user()->username }})</span>
                </div>
                <div class="text-xs font-medium
                    {{ auth()->user()->identity === 'employer' ? 'text-blue-600' : 'text-green-600' }}">
                    {{ ucfirst(auth()->user()->identity) }}
                </div>
            </div>

            <!-- Dashboard button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Dashboard
            </a>

            @if ( auth()->user()->identity == 'employer' )

            @elseif ( auth()->user()->identity == 'seeker' )

            @endif

            <!-- Logout button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
