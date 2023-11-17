<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use App\Services\admin\ScreeningService;
use DateInterval;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    private ScreeningService $screeningService;

    public function __construct(ScreeningService $screeningService)
    {
        $this->screeningService = $screeningService;
    }

    /**
     * @throws \Exception
     */
    public function createScreening(Request $request)
    {
        $request->validate([
            'hall' => 'required',
            'screening-start-time' => 'required',
            'movie' => 'required'
        ]);
        $this->screeningService->createScreening($request->all());

        return back();
    }

    public function deleteScreening(Request $request)
    {
        $this->screeningService->deleteScreening($request->get('screening_id'));

        return back();
    }
}
