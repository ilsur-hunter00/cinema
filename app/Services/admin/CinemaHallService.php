<?php

namespace App\Services\admin;

use App\Models\CinemaHall;
use App\Models\Seat;

class CinemaHallService
{
    public function createHall($data)
    {
        (new CinemaHall)::create($data);
    }

    public function deleteHall($id)
    {
        CinemaHall::query()->where('id', $id)->delete();
    }

    public function createHallDetail($hallId, $rows, $seatsPerRow)
    {
        $hall = CinemaHall::query()->where('id', $hallId)->first();
        if ($hall) {
            $seats = Seat::query()->where('cinema_hall_id', $hallId)->get();
            if ($seats) {
                foreach ($seats as $seat) {
                    $seat->delete();
                }
            }
        }
        CinemaHall::query()->where('id', $hallId)->update([
            'rows' => $rows,
            'seats_per_row' => $seatsPerRow
        ]);
    }
}
