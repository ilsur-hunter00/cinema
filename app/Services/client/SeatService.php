<?php

namespace App\Services\client;

use App\Models\Seat;

class SeatService
{
    public function chooseSeats($rows, $data)
    {
        foreach ($rows as $row) {
            foreach ($row as $seat) {
                $type = array_key_first($seat);
                $explodedArray = explode(',', array_values($seat)[0]);
                $rowItem = $explodedArray[0];
                $seatItem = $explodedArray[1];
                $matchThese = [
                    'cinema_hall_id' => $data['cinema_hall_id'],
                    'row_number' => $rowItem,
                    'seat_number' => $seatItem,
                ];

                $seat = Seat::where($matchThese)->first();

                $seat->update(['type' => $type]);
            }
        }
    }
}
