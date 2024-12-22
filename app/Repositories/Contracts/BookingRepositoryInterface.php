<?php

namespace App\Repositories\Contracts;


interface BookingRepositoryInterface
{
    public function createBooking(array $data);
    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber);
    public function saveToSession(array $data);
    public function updatesSessionData(array $data);
    public function getBookingDataFromSession();
    public function clearSession();
}
