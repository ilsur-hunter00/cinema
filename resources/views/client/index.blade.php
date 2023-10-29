@extends('layouts.client')

@section('content')

    <nav class="page-nav">
        @for ($i = 0; $i < $numberOfDays; $i++)
            @php
                $currentDate = \Carbon\Carbon::now()->addDays($i);
                $dayOfWeek = $currentDate->isoFormat('dd');
                $dayOfMonth = $currentDate->day;
                $isWeekend = in_array($currentDate->dayOfWeek, [6, 0]);
            @endphp
            @php
                $isCurrentDate = $currentDate->format('m-d') == (new DateTime($currentDateServer))->format('m-d')
            @endphp

            <a class="page-nav__day
            {{ $i === 0 ? 'page-nav__day_today' : '' }}
            {{ $isWeekend ? ' page-nav__day_weekend' : '' }}
            {{ $isCurrentDate ? 'page-nav__day_chosen' : '' }}"
               href="{{ route('get_client_info', ['currentDate' => $currentDate->format('Y-m-d H:i:s')]) }}">
                <span class="page-nav__day-week">{{ $dayOfWeek }}</span><span class="page-nav__day-number">{{ $dayOfMonth }}</span>
            </a>
        @endfor
        <a class="page-nav__day page-nav__day_next" href="#" onclick="moveToNextDay()"></a>
    </nav>

    <main>
        @foreach($movies as $movie)
            <section class="movie">
                <div class="movie__info">
                    <div class="movie__poster">
                        <img class="movie__poster-image" alt="Звёздные войны постер" src="{{ asset('client/images/poster1.jpg') }}">
                    </div>
                    <div class="movie__description">
                        <h2 class="movie__title">{{ $movie->title }}</h2>
                        <p class="movie__synopsis">{{ $movie->description }}</p>
                        <p class="movie__data">
                            <span class="movie__data-duration">{{ $movie->duration }} минут</span>
                        </p>
                    </div>
                </div>

                @foreach($halls as $hall)
                    <div class="movie-seances__hall">
                        <h3 class="movie-seances__hall-title">{{ $hall->name }}</h3>
                        <ul class="movie-seances__list">
                            @foreach($screenings as $screening)
                                <li class="movie-seances__time-block">
                                    <a
                                        @if(!\App\Models\User::where('name', 'admin')->first()->is_opened_sells)
                                            style="color: grey;pointer-events: none;background-color: #f0f0f0;cursor: not-allowed;"
                                        @endif
                                        class="movie-seances__time"
                                        href="{{ route('get_hall', $screening->id) }}">
                                        {{ (new DateTime($screening->start_time))->format('H:i') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </section>
        @endforeach
    </main>

@endsection
