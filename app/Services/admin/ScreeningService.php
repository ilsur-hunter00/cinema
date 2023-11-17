<?php

namespace App\Services\admin;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use DateInterval;

class ScreeningService
{
    /**
     * @throws \Exception
     */
    public function createScreening($data)
    {
        $hallId = CinemaHall::query()->where('id', (int) $data['hall'])->first()->id;
        $movie = Movie::query()->where('id', (int) $data['movie'])->first();
        $movieId = $movie->id;
        $movieDuration = $movie->duration;
        $dateTimeStart = date_create($data['screening-start-time']);
        $startTime = date_format($dateTimeStart, 'Y-m-d H:i:s');
        $endTime = $dateTimeStart->add(new DateInterval('PT'.$movieDuration.'M'));

        (new Screening())->create([
            'cinema_hall_id' => $hallId,
            'movie_id' => $movieId,
            'start_time' => $startTime,
            'end_time' => $endTime
        ]);
    }

    public function deleteScreening($id)
    {
        Screening::query()->where('id', $id)->delete();
    }
}
