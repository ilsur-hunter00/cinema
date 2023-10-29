@extends('layouts.client')

@section('content')

  <main>
    <section class="ticket">

      <header class="tichet__check">
        <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
      </header>

      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $movie->title }}</span></p>
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

        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $hall->name }}</span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ (new DateTime($screening->start_time))->format('H:i') }}</span></p>
        <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ $sumPrice }}</span> рублей</p>

        <button class="acceptin-button" onclick="location.href='{{ route('get_ticket', ['cinema_hall_id' => $hall->id, 'screening_id' => $screening->id]) }}'" >Получить код бронирования</button>

        <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>
  </main>

@endsection
