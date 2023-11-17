<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetPriceRequest;
use App\Models\Seat;
use App\Services\admin\SeatService;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    private SeatService $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
    }

    public function createSeats(Request $request, int $id)
    {
        $rows = $request->input('seats');
        $this->seatService->createSeats($id, $rows);

        return back();
    }

    public function setPrice(SetPriceRequest $request, int $id)
    {
        $this->seatService->setPrice($id, $request->all());

        return back();
    }
}
