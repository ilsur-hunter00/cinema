<?php

namespace App\Services\admin;

use App\Models\Movie;

class MovieService
{
    public function createMovie($data)
    {
        (new Movie())->create([
            'title' => $data['movie-name'],
            'duration' => $data['movie-duration'],
            'description' => $data['movie-description'],
        ]);
    }
}
