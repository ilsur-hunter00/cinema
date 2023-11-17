<?php

namespace App\Services\admin;

use App\Models\Seat;

class SeatService
{
    public function createSeats($id, $rows)
    {
        foreach ($rows as $row) {
            foreach ($row as $seat) {
                $type = array_key_first($seat);
                $explodedArray = explode(',', array_values($seat)[0]);
                $rowItem = $explodedArray[0];
                $seatItem = $explodedArray[1];
                $matchThese = [
                    'cinema_hall_id' => $id,
                    'row_number' => $rowItem,
                    'seat_number' => $seatItem,
                ];

                $seat = Seat::where($matchThese)->first();

                if (!$seat) {
                    Seat::create([
                        'cinema_hall_id' => $id,
                        'type' => $type,
                        'row_number' => $rowItem,
                        'seat_number' => $seatItem,
                    ]);
                } else {
                    $seat->update(['type' => $type]);
                }
            }
        }
    }

    public function setPrice($id, $data)
    {
        $seats = Seat::query()->where('cinema_hall_id', $id)->get();
        foreach ($seats as $seat) {
            Seat::query()->where('type', 'standart')->update([
                'price' => $data['standart-chair']
            ]);
            Seat::query()->where('type', 'vip')->update([
                'price' => $data['vip-chair']
            ]);
        }
    }
}
