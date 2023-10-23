<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use App\Models\Seat;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $halls = CinemaHall::all();
        $selectedHallId = session('selected_hall');
        return view('admin.index', [
            'halls' => $halls,
            'selectedHallId' => $selectedHallId,
        ]);
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
                (new Seat)::create([
                    'cinema_hall_id' => $id,
                    'type' => $type,
                    'row_number' => $rowItem,
                    'seat_number' => $seatItem
                ]);
            }
        }

        return back();
    }
}
