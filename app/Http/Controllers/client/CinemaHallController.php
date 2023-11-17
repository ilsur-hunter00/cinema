<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use App\Services\client\CinemaHallService;
use Illuminate\Http\Request;

class CinemaHallController extends Controller
{
    private CinemaHallService $cinemaHallService;

    public function __construct(CinemaHallService $cinemaHallService)
    {
        $this->cinemaHallService = $cinemaHallService;
    }

    public function getHall(int $screeningId)
    {
        $hall = $this->cinemaHallService->getHall($screeningId);

        return view('client.hall', $hall);
    }
}
