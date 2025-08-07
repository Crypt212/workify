<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hidden-tab {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-md w-full max-w-md p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Register</h1>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Basic Info (Common to All) -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Full Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('name') }}">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('username') }}">
                @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('email') }}">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Identity Selection (Radio Buttons) -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">You are:</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="identity" value="seeker" class="form-radio h-5 w-5 text-blue-600"
                            checked onclick="showTab('seeker')">
                        <span class="ml-2">Job Seeker</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="identity" value="employer" class="form-radio h-5 w-5 text-blue-600"
                            onclick="showTab('employer')">
                        <span class="ml-2">Employer</span>
                    </label>
                </div>
                @error('identity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Seeker Tab -->
            <div id="seeker-tab" class="mb-4">
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 mb-2">Professional Role</label>
                    <input type="text" id="role" name="role"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('role') }}">
                    @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="skills" class="block text-gray-700 mb-2">Skills (comma separated)</label>
                    <input type="text" id="skills" name="skills"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('skills') }}" placeholder="e.g., PHP, Laravel, JavaScript">
                    @error('skills')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Employer Tab (Hidden by Default) -->
            <div id="employer-tab" class="mb-4 hidden-tab">
                <div class="mb-4">
                    <label for="organization_name" class="block text-gray-700 mb-2">Organization Name</label>
                    <input type="text" id="organization_name" name="organization_name"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('organization_name') }}">
                    @error('organization_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Register
            </button>
        </form>

        <div class="mt-4 text-center">
            <span class="text-gray-600">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline ml-1">Login</a>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById('seeker-tab').classList.add('hidden-tab');
            document.getElementById('employer-tab').classList.add('hidden-tab');

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden-tab');
        }
    </script>
</body>

</html>
