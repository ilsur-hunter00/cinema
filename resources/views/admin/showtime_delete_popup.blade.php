<div class="popup" id="popup-delete_showtime">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Снятие с сеанса
          <a class="popup__dismiss" href="#"><img src="{{ asset('admin/images/close.png') }}" alt="Закрыть"></a>
        </h2>

      </div>
      <div class="popup__wrapper">
          <form action="{{ route('delete_screening') }}" method="get" accept-charset="utf-8">
              @csrf
              <input type="hidden" id="screening-id" name="screening_id" value="">
              <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм <span id="movie-title"></span>?</p>
              <div class="conf-step__buttons text-center">
                  <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
              </div>
          </form>
      </div>
    </div>
  </div>
</div>
