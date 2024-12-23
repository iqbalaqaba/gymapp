<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use App\Models\User;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'license_type' => 'required|string',
            'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Save the payment proof file
        $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Save the payment data
        Payment::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'license_type' => $request->license_type,
            'payment_proof' => $filePath,
        ]);

        // Redirect to the license list with a success message
        return redirect()->route('licenses.list')->with('success', 'Payment submitted successfully!');
    }
}
