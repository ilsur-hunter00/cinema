<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHallDetailRequest;
use App\Http\Requests\CreateHallRequest;
use App\Models\CinemaHall;
use App\Models\Seat;
use App\Services\admin\CinemaHallService;
use Illuminate\Http\Request;

class CinemaHallController extends Controller
{
    private CinemaHallService $cinemaHallService;

    public function __construct(CinemaHallService $cinemaHallService)
    {
        $this->cinemaHallService = $cinemaHallService;
    }

    public function setCurrentHall(Request $request, int $id)
    {
        $hallId = CinemaHall::query()->where('id', $id)->first()->id;
        session(['selected_hall' => $hallId]);
        return back();
    }

    public function createHall(CreateHallRequest $request)
    {
        $data = [
            'name' => $request->input('hall_name')
        ];
        $this->cinemaHallService->createHall($data);

        return back();
    }

    public function deleteHall(int $id)
    {
        $this->cinemaHallService->deleteHall($id);

        return back();
    }

    public function createHallDetail(CreateHallDetailRequest $request)
    {
        $hallId = $request->input('chairs-hall');
        session(['selected_hall' => $hallId]);
        $this->cinemaHallService
            ->createHallDetail($hallId, $request->get('rows'), $request->get('seats_per_row'));

        return back();
    }
}
