<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMovieRequest;
use App\Models\Movie;
use App\Services\admin\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function createMovie(CreateMovieRequest $request)
    {
        $this->movieService->createMovie($request->all());

        return back();
    }
}
