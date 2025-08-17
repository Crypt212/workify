<x-wrapper>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Seeker Dashboard</h2>
            <p class="text-gray-600 mb-4">Manage your job posts and applications.</p>

            @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
            @endif
            <!-- User Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4 border-b pb-2">Personal Information</h3>
                <form action='{{ route("dashboard.update") }}' method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="contact_info" class="block text-sm font-medium text-gray-700">Contact
                                Number</label>
                            <input type="tel" id="contact_info" name="contact_info"
                                value="{{ auth()->user()->contact_info ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('contact_info')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if (auth()->user()->identity == 'employer')
                        <div>
                            <label for="organization_name" class="block text-sm font-medium text-gray-700">Organization Name</label>
                            <input type="text" id="organization_name" name="organization_name" value="{{ auth()->user()->employer->organization_name ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('organization_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        @if (auth()->user()->identity == 'seeker')
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Professional Role</label>
                            <input type="text" id="role" name="role" value="{{ auth()->user()->seeker->role ?? '' }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                    </div>

                    @if (auth()->user()->identity == 'seeker')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Skills</label>
                        <div class="mt-1 p-3 border border-gray-300 rounded-md bg-gray-50">
                            <!-- Skills component placeholder -->
                            <x-skill-proficiency-input :skills="auth()->user()->seeker->skills->toArray()" />
                            @error('skills')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Section -->
            <div>
                <h3 class="text-lg font-medium mb-4 border-b pb-2">Security</h3>
                <form action=" {{ route('dashboard.update-password') }} " method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current
                                Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New
                                Password</label>
                            <input type="password" id="new_password" name="new_password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-wrapper>
