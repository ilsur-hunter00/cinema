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

    public function getHall(int $screeningId)
    {
        $screening = Screening::where('id', $screeningId)->first();

        $hall = $screening->cinemaHall;

        $seats = $hall->seats;

        $movie = $screening->movie;

        return view('client.hall', [
            'movie' => $movie,
            'hall' => $hall,
            'screening' => $screening,
            'seats' => $seats
        ]);
    }

    public function chooseSeats(Request $request)
    {
        $rows = $request->input('seats');

        foreach ($rows as $row) {
            foreach ($row as $seat) {
                $type = array_key_first($seat);
                $explodedArray = explode(',', array_values($seat)[0]);
                $rowItem = $explodedArray[0];
                $seatItem = $explodedArray[1];
                $matchThese = [
                    'cinema_hall_id' => $request->get('cinema_hall_id'),
                    'row_number' => $rowItem,
                    'seat_number' => $seatItem,
                ];

                $seat = Seat::where($matchThese)->first();

                $seat->update(['type' => $type]);
            }
        }

        return redirect()->route('get_payment', [
            'screening_id' => $request->get('screening_id'),
        ]);
    }

    public function getTicket(Request $request)
    {
        $screening = Screening::where('id', $request->get('screening_id'))->first();
        $hall = $screening->cinemaHall;
        $seats = $hall->seats()->where('type', 'selected')->get([
            'row_number', 'seat_number', 'price'
        ]);
        $sumPrice = 0;
        foreach ($seats as $seat) {
            $sumPrice += $seat->price;
        }
        $movie = $screening->movie;

        $from = [255, 0, 0];
        $to = [0, 0, 255];
        $qrCode = QrCode::size(200)
            ->style('dot')
            ->eye('circle')
            ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
            ->margin(1)
            ->generate(
                utf8_encode("
                    Название фильма: {$movie->title}
                    Зал: {$hall->name}
                    Начало сеанса: ". (new DateTime($screening->start_time))->format('H:i'). "
                    Стоимость: {$sumPrice} рублей
                ")
            );

        return view('client.ticket', [
            'hall' => $hall,
            'movie' => $movie,
            'screening' => $screening,
            'seats' => $seats,
            'sumPrice' => $sumPrice,
            'qrCode' => $qrCode
        ]);
    }

    public function getPayment(Request $request)
    {
        $screening = Screening::where('id', $request->get('screening_id'))->first();
        $hall = $screening->cinemaHall;
        $seats = $hall->seats()->where('type', 'selected')->get([
            'id', 'row_number', 'seat_number', 'price'
        ]);
        $sumPrice = 0;
        foreach ($seats as $seat) {
            $sumPrice += $seat->price;
        }
        $movie = $screening->movie;

        return view('client.payment', [
            'hall' => $hall,
            'movie' => $movie,
            'screening' => $screening,
            'seats' => $seats,
            'sumPrice' => $sumPrice,
        ]);
    }
}
