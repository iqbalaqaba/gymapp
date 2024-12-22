<?php

namespace App\Repositories\Contracts;

interface SubscribePackageRepositoryInterface
{
    public function getAllSubscriberPackages();
    public function find($id);
    public function getPrice($subscribePackageId);
}
