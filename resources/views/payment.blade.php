<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Payment</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Selected License</h2>
                <p class="mb-4"><strong>License:</strong> 
                    {{ request('license', 'monthly') === 'yearly' ? 'Yearly License' : 'Monthly License' }}
                </p>
                <p class="mb-4"><strong>Price:</strong> 
                    {{ request('license', 'monthly') === 'yearly' ? '$200' : '$20' }}
                </p>

                <h3 class="text-xl font-bold mt-6 mb-4">User Details</h3>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Your Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="Enter your name" 
                        required 
                        class="w-full p-3 border rounded-lg"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Your Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Enter your email" 
                        required 
                        class="w-full p-3 border rounded-lg"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Create a password" 
                        required 
                        class="w-full p-3 border rounded-lg"
                    >
                </div>
            </div>

            <!-- Right Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Payment Details</h2>
                <p class="mb-4"><strong>Transfer to:</strong></p>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="font-bold">Bank Mandiri</p>
                    <p class="text-gray-700">Account Name: John Doe</p>
                    <p class="text-gray-700">Account Number: 123-456-789</p>
                </div>

                <h3 class="text-xl font-bold mt-6 mb-4">Upload Payment Proof</h3>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Upload File</label>
                    <input 
                        type="file" 
                        name="payment_proof" 
                        required 
                        class="w-full p-3 border rounded-lg"
                    >
                </div>

                <div class="text-center">
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                        Submit Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>