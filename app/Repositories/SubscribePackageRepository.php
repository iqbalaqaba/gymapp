<?php

namespace App\Repositories;

use App\Models\SubscribePackage;
use App\Repositories\Contracts\SubscribePackageRepositoryInterface;

class SubscribePackageRepository implements SubscribePackageRepositoryInterface
{

    public function getAllSubscriberPackages()
    {
        return SubscribePackage::orderBy('id', 'asc')->get();
    }

    public function find($id)
    {
        return SubscribePackage::find($id);
    }

    public function getPrice($subscribePackageId)
    {
        $subscribePackage = $this->find($subscribePackageId);
        return $subscribePackage ? $subscribePackage->price : 0;
    }
}
