<?php

namespace App\Services\client;

use App\Models\Screening;
use DateTime;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketService
{
    /**
     * @throws \Exception
     */
    public function getTicket($data)
    {
        $screening = Screening::where('id', $data['screening_id'])->first();
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

        return compact('hall', 'movie', 'screening', 'seats', 'sumPrice', 'qrCode');
    }

    public function getPayment($data)
    {
        $screening = Screening::where('id', $data['screening_id'])->first();
        $hall = $screening->cinemaHall;
        $seats = $hall->seats()->where('type', 'selected')->get([
            'id', 'row_number', 'seat_number', 'price'
        ]);
        $sumPrice = 0;
        foreach ($seats as $seat) {
            $sumPrice += $seat->price;
        }
        $movie = $screening->movie;

        return compact('hall', 'movie', 'screening', 'seats', 'sumPrice');
    }
}
