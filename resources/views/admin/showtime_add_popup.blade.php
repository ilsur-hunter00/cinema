<div class="popup" id="popup-add_showtime">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление сеанса
          <a class="popup__dismiss" href="#"><img src="{{ asset('admin/images/close.png') }}" alt="Закрыть"></a>
        </h2>

      </div>
      <div class="popup__wrapper">
        <form action="{{ route('add_screening') }}" method="post" accept-charset="utf-8">
            @csrf
            <label class="conf-step__label conf-step__label-fullsize" for="hall">
              Название зала
              <select class="conf-step__input" name="hall" required>
                  @foreach($halls as $hall)
                      <option value="{{ $hall->id }}" selected name="hall_name">{{ $hall->name }}</option>
                  @endforeach
              </select>
            </label>

            <label class="conf-step__label conf-step__label-fullsize" for="screening-start-time">
              Время начала
              <input class="conf-step__input" type="time" value="00:00" name="screening-start-time" required>
            </label>

            <label class="conf-step__label conf-step__label-fullsize" for="movie">
                Название фильма
                <select class="conf-step__input" name="movie" required>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" selected name="movie_name">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </label>

          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
