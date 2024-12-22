<?php

namespace App\Services;

use App\Models\SubscribeTransaction;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\SubscribePackageRepositoryInterface;
use Illuminate\Support\Facades\DB;


class BookingService
{
    protected $subscribePackageRepository;
    protected $bookingRepository;

    public function __construct(
        SubscribePackageRepositoryInterface $subscribePackageRepository,
        BookingRepositoryInterface $bookingRepository
    ) {
        $this->subscribePackageRepository = $subscribePackageRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function getBookingDetails(array $validated)
    {
        return $this->bookingRepository->findByTrxIdAndPhoneNumber($validated['booking_trx_id'], $validated['phone']);
    }

    public function calculateBookingData($subscribePackage, $validatedData)
    {
        $duration = $subscribePackage->duration;
        $startedAt = now();
        $endedAt = $startedAt->clone()->addDays($duration);

        $ppn = 0.12;
        $price = $subscribePackage->price;

        $subTotal = $price;
        $totalPpn = $ppn * $subTotal;
        $totalAmmount = $subTotal + $totalPpn;

        return [
            'subscribe_package_id' => $subscribePackage->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'duration' => $duration,
            'phone' => $validatedData['phone'],
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
            'sub_total' => $subTotal,
            'total_ppn' => $totalPpn,
            'total_ammount' => $totalAmmount
        ];
    }

    public function storeBookingSession($subscribePackage, array $validatedData)
    {
        $bookingData = $this->calculateBookingData($subscribePackage, $validatedData);
        $this->bookingRepository->saveToSession($bookingData);

        $validated['total_ammount'] = $validated['total_ammount'] ?? $subscribePackage->price * 1.12; // Ensure 'total_ammount' is calculated
        session(['booking' => $validated]);
    }

    public function payment()
    {
        $booking = $this->bookingRepository->getBookingDataFromSession();
        $subscribePackage = $this->subscribePackageRepository->find($booking['subscribe_package_id']);

        return compact('booking', 'subscribePackage');
    }

    public function paymentStore(array $validated)
    {

        $bookingData = $this->bookingRepository->getBookingDataFromSession();
        $bookingTransactionId = null;

        // Ensure total_ammount is set
        $validated['total_ammount'] = $bookingData['total_ammount'] ?? $this->calculateBookingData(
            $this->subscribePackageRepository->find($bookingData['subscribe_package_id']),
            $validated
        )['total_ammount'];


        DB::transaction(function () use ($validated, &$bookingTransactionId, $bookingData) {
            if (isset($validated['proof'])) {
                $proofPath = $validated['proof']->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['name'] = $bookingData['name'];
            $validated['email'] = $bookingData['email'];
            $validated['phone'] = $bookingData['phone'];
            $validated['duration'] = $bookingData['duration'];
            $validated['total_ammount'] = $bookingData['total_ammount'];
            $validated['subscribe_package_id'] = $bookingData['subscribe_package_id'];
            $validated['started_at'] = $bookingData['started_at'];
            $validated['ended_at'] = $bookingData['ended_at'];
            $validated['is_paid'] = false;

            $validated['booking_trx_id'] = SubscribeTransaction::generatUniqueTrxId();

            $newBooking = $this->bookingRepository->createBooking($validated);

            $bookingTransactionId = $newBooking->id;
        });

        return $bookingTransactionId;
    }
}
