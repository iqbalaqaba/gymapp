<?php

namespace App\Repositories;

use App\Models\Cities;

use App\Repositories\Contracts\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    public function getAllCities()
    {
        return Cities::latest()->get();
    }
}
