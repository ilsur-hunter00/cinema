@extends('layouts.client')

@section('content')

  <main>
    <section class="ticket">

      <header class="tichet__check">
        <h2 class="ticket__check-title">Электронный билет</h2>
      </header>

      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $movie->title }}</span></p>
        <p class="ticket__info">Места:
            <span class="ticket__details ticket__chairs">
                @foreach($seats as $seat)
                    <p class="ticket__info" style="display: inline-block; margin-right: 10px;">Ряд:
                        <span class="ticket__details ticket__chairs">
                            {{ $seat->row_number }}
                        </span>
                    </p>
                    <p class="ticket__info" style="display: inline-block; margin-right: 10px;">Место:
                        <span class="ticket__details ticket__chairs">
                            {{ $seat->seat_number }}
                        </span>
                    </p>
                    <br>
                @endforeach
                <br>
            </span></p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $hall->name }}</span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ (new DateTime($screening->start_time))->format('H:i') }}</span></p>

        <p class="ticket__info-qr">{{ $qrCode }}</p>

        <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>
  </main>

@endsection
