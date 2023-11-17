<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $currentDateServer = $request->input('currentDate', $now->format('Y-m-d H:i:s'));;
        $screenings = Screening::whereRaw("DAY(start_time) = DAY('$currentDateServer')")->get();

        $halls = CinemaHall::whereHas('screenings', function ($query) use ($currentDateServer) {
            $query->whereRaw("DAY(start_time) = DAY('$currentDateServer')");
        })->get();

        $movies = Movie::whereHas('screenings', function ($query) use ($currentDateServer) {
            $query->whereRaw("DAY(start_time) = DAY('$currentDateServer')");
        })->get();

        return view('client.index', [
            'movies' => $movies,
            'halls' => $halls,
            'screenings' => $screenings,
            'dayOfMonth' => $now,
            'dayOfWeek' => $now->isoFormat('dd'),
            'numberOfDays' => 5,
            'currentDateServer' => $currentDateServer
        ]);
    }
}
