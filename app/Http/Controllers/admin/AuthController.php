<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function login()
    {
        validator(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (auth()->attempt(request()->only(['email', 'password']))) {
            return redirect('/admin-panel');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid Credentials!']);
    }
}
