<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Services\client\SeatService;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    private SeatService $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
    }

    public function chooseSeats(Request $request)
    {
        $rows = $request->input('seats');
        $this->seatService->chooseSeats($rows, $request->all());

        return redirect()->route('get_payment', [
            'screening_id' => $request->get('screening_id'),
        ]);
    }
}
