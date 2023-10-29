@extends('layouts.client')

@section('content')

    <main>
        <section class="buying">
            <div class="buying__info">
                <div class="buying__info-description">
                    <h2 class="buying__info-title">{{ $movie->title }}</h2>
                    <p class="buying__info-start">Начало сеанса: {{ (new DateTime($screening->start_time))->format('H:i') }}</p>
                    <p class="buying__info-hall">{{ $hall->name }}</p>
                </div>
                <div class="buying__info-hint">
                    <p>Тапните дважды,<br>чтобы увеличить</p>
                </div>
            </div>
            <form method="post" action="{{ route('choose_seats', ['cinema_hall_id' => $hall->id, 'screening_id' => $screening->id]) }}">
                @csrf
                <div class="buying-scheme">
                    <div class="buying-scheme__wrapper">
                        @for($i = 0; $i < $hall->rows; $i++)
                            <div class="buying-scheme__row">
                                @for($j = 0; $j < $hall->seats_per_row; $j++)
                                    @php
                                        $seat = $seats->where('row_number', $i)->where('seat_number', $j)->first();
                                        if ($seat) {
                                            $seatStatus = $seat->type;
                                            if ($seat->type == 'selected') {
                                                $seatStatus = 'taken';
                                            }
                                        } else {
                                            $seatStatus = 'standart';
                                        }
                                    @endphp
                                    <input name="seats[{{ $i }}][{{ $j }}][{{$seatStatus}}]" value="{{ $i . ',' . $j }}"
                                           class="buying-scheme__chair buying-scheme__chair_{{$seatStatus}}"
                                           data-i="{{ $i }}" data-j="{{ $j }}" data-chair-type="{{$seatStatus}}"
                                           data-previous-chair-type="{{$seatStatus}}">
                                @endfor
                            </div>
                        @endfor
                    </div>
                    <div class="buying-scheme__legend">
                        <div class="col">
                            @if($seats->where('type', 'standart')->first() !== null)
                                <p class="buying-scheme__legend-price"><span
                                        class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span
                                        class="buying-scheme__legend-value">{{ intval($seats->where('type', 'standart')->first()->price) }}</span>руб)
                                </p>
                            @endif

                            @if($seats->where('type', 'vip')->first() !== null)
                                <p class="buying-scheme__legend-price"><span
                                        class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span
                                        class="buying-scheme__legend-value">{{ intval($seats->where('type', 'vip')->first()->price) }}</span>руб)
                                </p>
                            @endif
                        </div>
                        <div class="col">
                            <p class="buying-scheme__legend-price"><span
                                    class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                            <p class="buying-scheme__legend-price"><span
                                    class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="acceptin-button">Забронировать</button>
            </form>
        </section>
    </main>

@endsection
