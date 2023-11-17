<?php

namespace App\Services\client;

use App\Models\Screening;

class CinemaHallService
{
    public function getHall($screeningId)
    {
        $screening = Screening::where('id', $screeningId)->first();

        $hall = $screening->cinemaHall;

        $seats = $hall->seats;

        $movie = $screening->movie;

        return compact('screening', 'hall', 'seats', 'movie');
    }
}
