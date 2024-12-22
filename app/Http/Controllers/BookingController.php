<?php

namespace App\Http\Controllers;

use App\Models\SubscribePackage;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreCheckBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\SubscribeTransaction;

class BookingController extends Controller
{
    //

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function booking(SubscribePackage $subscribePackage)
    {
        $tax = 0.12;
        $totalTaxAmount = $tax * $subscribePackage->price;
        $grandTotalAmount = $subscribePackage->price + $totalTaxAmount;
        // $validated['total_ammount'] = $grandTotalAmount;


        // return view('booking.checkout', compact('subscribePackage', 'totalTaxAmount', 'grandTotalAmount'));
        return view('booking.checkout', [
            'subscribePackage' => $subscribePackage,
            'totalTaxAmount' => $totalTaxAmount,
            'grandTotalAmount' => $grandTotalAmount,
        ]);
    }

    public function bookingStore(SubscribePackage $subscribePackage, StoreBookingRequest $request)
    {
        $validated = $request->validated();

        $tax = 0.12;
        $totalTaxAmount = $tax * $subscribePackage->price;
        $grandTotalAmount = $subscribePackage->price + $totalTaxAmount;

        $validated['total_ammount'] = $grandTotalAmount;


        try {
            $this->bookingService->storeBookingSession($subscribePackage, $validated);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to store booking, please try again']);
        }

        return redirect()->route('front.payment');
    }

    public function payment()
    {
        $data = $this->bookingService->payment();
        // dd($data);
        return view('booking.payment', $data);
    }

    // public function paymentStore(StorePaymentRequest $request)
    // {
    //     $validated = $request->validated();

    //     // Generate a transaction ID
    //     $bookingTransactionid = $this->bookingService->paymentStore($validated);


    //     if ($bookingTransactionid) {
    //         // Redirect to the correct route
    //         return redirect()->route('front.booking_finished', ['subscribeTransaction' => $bookingTransactionid]);
    //     }

    //     // Handle the fallback
    //     return redirect()->route('front.index')->withErrors(['error' => 'Payment failed, please try again']);
    // }

    public function paymentStore(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        $bookingTransactionid = $this->bookingService->paymentStore($validated);

        if ($bookingTransactionid) {
            return redirect()->route('front.booking_finished', ['subscribeTransaction' => $bookingTransactionid]);
        }

        return redirect()->route('front.index')->withErrors(['error' => 'Payment failed, please try again']);
    }

    public function bookingFinished(SubscribeTransaction $subscribeTransaction)
    {
        return view('booking.booking_finished', compact('subscribeTransaction'));
    }

    public function checkBooking()
    {
        return view('booking.check_booking');
    }

    public function checkBookingDetails(StoreCheckBookingRequest $request)
    {
        $validated = $request->validated();

        $bookingDetails = $this->bookingService->getBookingDetails($validated);

        if ($bookingDetails) {
            return view('booking.check_booking_details', compact('bookingDetails'));
        }

        return redirect()->route('booking.check_bookign')->withErrors(['error' => 'Transaction not found']);
    }
}
