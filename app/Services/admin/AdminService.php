<?php

namespace App\Services\admin;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;

class AdminService
{
    public function getAdminPanel()
    {
        $halls = CinemaHall::all();
        $selectedHallId = session('selected_hall') ?? 1;
        $movies = Movie::all();
        $screenings = Screening::all();
        $seatStatuses = Seat::query()->where('cinema_hall_id', $selectedHallId)->get();

        return compact('halls', 'selectedHallId', 'movies', 'screenings', 'seatStatuses');
    }

    public function openSells()
    {
        User::query()->where('name', 'admin')->update([
            'is_opened_sells' => true
        ]);
    }
}
