<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto py-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center mb-6">Available Licenses</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Monthly License -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Monthly License</h2>
                <p class="text-gray-700 mb-4">Access all gym features for one month.</p>
                <p class="text-lg font-semibold text-blue-500">Price: $20</p>
                <div class="mt-4">
                    <a href="/payment?license=monthly" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Buy Now
                    </a>
                </div>
            </div>

            <!-- Yearly License -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Yearly License</h2>
                <p class="text-gray-700 mb-4">Enjoy uninterrupted access for a full year.</p>
                <p class="text-lg font-semibold text-blue-500">Price: $200</p>
                <div class="mt-4">
                    <a href="/payment?license=yearly" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Buy Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>