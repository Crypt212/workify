<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Employer Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white shadow-md rounded-md max-w-md w-full p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">👤 Employer Profile</h1>

        @if($employer)
            <div class="space-y-4 text-gray-700">
                <div>
                    <span class="font-semibold">Name: </span> {{ $employer->user->name }}
                </div>
                <div>
                    <span class="font-semibold">Email: </span> {{ $employer->user->email }}
                </div>
                <div>
                    <span class="font-semibold">Company: </span> {{ $employer->company_name ?? 'N/A' }}
                </div>
                <div>
                    <span class="font-semibold">Phone: </span> {{ $employer->phone ?? 'N/A' }}
                </div>
            </div>
        @else
            <p class="text-red-500 text-center">Employer data not found.</p>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('seeker.inbox') }}" class="text-blue-600 hover:underline">
                ← Back to Inbox
            </a>
        </div>
    </div>

</body>
</html>
