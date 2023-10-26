<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;
use DateInterval;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $halls = CinemaHall::all();
        $selectedHallId = session('selected_hall') ?? 1;
        $movies = Movie::all();
        $screenings = Screening::all();
        $seatStatuses = Seat::query()->where('cinema_hall_id', $selectedHallId)->get();

        return view('admin.index', [
            'halls' => $halls,
            'selectedHallId' => $selectedHallId,
            'movies' => $movies,
            'screenings' => $screenings,
            'seatStatuses' => $seatStatuses
        ]);
    }

    public function setCurrentHall(Request $request, int $id)
    {
        $hallId = CinemaHall::query()->where('id', $id)->first()->id;
        session(['selected_hall' => $hallId]);
//        $selectedHallId = session('selected_hall') ?? 1;
        return back();
    }

    public function createHall(Request $request)
    {
        $request->validate([
            'hall_name' => 'required|string',
        ]);

        $data = [
            'name' => $request->get('hall_name')
        ];

        (new CinemaHall)::create($data);

        return back();
    }

    public function deleteHall(int $id)
    {
        CinemaHall::query()->where('id', $id)->delete();

        return back();
    }

    public function createHallDetail(Request $request)
    {
        $request->validate([
            'rows' => 'required|numeric',
            'seats_per_row' => 'required|numeric'
        ]);

        $hallId = $request->input('chairs-hall');
        session(['selected_hall' => $hallId]);
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
            'rows' => $request->get('rows'),
            'seats_per_row' => $request->get('seats_per_row')
        ]);

        return back();
    }

    public function createSeats(Request $request, int $id)
    {
        $rows = $request->input('seats');

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

        return back();
    }

    public function setPrice(Request $request, int $id)
    {
        $request->validate([
            'standart-chair' => 'required|numeric',
            'vip-chair' => 'required|numeric'
        ]);

        $seats = Seat::query()->where('cinema_hall_id', $id)->get();
        foreach ($seats as $seat) {
            Seat::query()->where('type', 'standart')->update([
                'price' => $request->get('standart-chair')
            ]);
            Seat::query()->where('type', 'vip')->update([
                'price' => $request->get('vip-chair')
            ]);
        }

        return back();
    }

    public function createMovie(Request $request)
    {
        $request->validate([
            'movie-name' => 'required|string',
            'movie-duration' => 'required|numeric'
        ]);

        (new Movie())->create([
            'title' => $request->get('movie-name'),
            'duration' => $request->get('movie-duration')
        ]);

        return back();
    }

    /**
     * @throws \Exception
     */
    public function createScreening(Request $request)
    {
        $request->validate([
            'hall' => 'required',
            'screening-start-time' => 'required',
            'movie' => 'required'
        ]);
        $hallId = CinemaHall::query()->where('id', (int) $request->get('hall'))->first()->id;
        $movie = Movie::query()->where('id', (int) $request->get('movie'))->first();
        $movieId = $movie->id;
        $movieDuration = $movie->duration;
        $dateTimeStart = date_create($request->get('screening-start-time'));
        $startTime = date_format($dateTimeStart, 'Y-m-d H:i:s');
        $endTime = $dateTimeStart->add(new DateInterval('PT'.$movieDuration.'M'));

        (new Screening())->create([
            'cinema_hall_id' => $hallId,
            'movie_id' => $movieId,
            'start_time' => $startTime,
            'end_time' => $endTime
        ]);

        return back();
    }

    public function deleteScreening(Request $request)
    {
        Screening::query()->where('id', $request->get('screening_id'))->delete();

        return back();
    }

    public function openSells(Request $request)
    {
        User::query()->where('name', 'admin')->update([
            'is_opened_sells' => true
        ]);

        return redirect()->back()->with('is_opened_sells', true);
    }
}
