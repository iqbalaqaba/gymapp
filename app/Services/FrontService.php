<?php

namespace App\Services;

use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\GymRepositoryInterface;
use App\Repositories\Contracts\SubscribePackageRepositoryInterface;
use App\Repositories\GymRepository;
use App\Repositories\SubscribePackageRepository;

class FrontService
{

    protected $gymRepository;
    protected $cityRepository;
    protected $subscribePackageRepository;

    public function __construct(CityRepositoryInterface $cityRepository, GymRepositoryInterface $gymRepository, SubscribePackageRepositoryInterface $subscribePackageRepository)
    {
        $this->gymRepository = $gymRepository;
        $this->cityRepository = $cityRepository;
        $this->subscribePackageRepository = $subscribePackageRepository;
    }

    public function getFrontPageData()
    {
        $cities = $this->cityRepository->getAllCities();
        $popularGyms = $this->gymRepository->getPopularGyms(10);
        $newGyms = $this->gymRepository->getAllNewGyms();

        return compact('cities', 'popularGyms', 'newGyms');
    }

    public function getSubscriptionsData()
    {
        $subscribePackages = $this->subscribePackageRepository->getAllSubscriberPackages();
        return compact('subscribePackages');
    }
}
