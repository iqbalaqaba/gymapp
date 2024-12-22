<?php

namespace App\Http\Controllers;

use App\Services\FrontService;

use App\Models\Gym;
use App\Models\Cities;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //

    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);

        // dd($data);
    }

    public function pricing()
    {
        $data = $this->frontService->getSubscriptionsData();
        return view('front.pricing', $data);
        // dd($data);
    }

    public function details(Gym $gym)
    {
        return view('front.details', compact('gym'));
        // dd($gym);
    }

    public function city(Cities $city)
    {
        return view('front.city', compact('city'));
        // dd($city);
    }
}
