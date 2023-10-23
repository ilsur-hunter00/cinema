@extends('layouts.admin')

@section('content')

    @include('admin.hall_delete_popup')
    @include('admin.hall_add_popup')
    @include('admin.movie_add_popup')
    @include('admin.showtime_add_popup')
    @include('admin.showtime_delete_popup')


    <main class="conf-steps">
        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Управление залами</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">Доступные залы:</p>
                <ul class="conf-step__list">
                    @foreach($halls as $hall)
                        <li>{{ $hall->name }}
                            <a href="{{ route('delete_hall', $hall->id) }}" class="conf-step__button conf-step__button-trash" data-target="#popup-delete_hall"></a>
                        </li>
                    @endforeach
                </ul>
                <button class="conf-step__button conf-step__button-accent" data-target="#popup-add_hall">Создать зал</button>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Конфигурация залов</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                <form method="post" action="{{ route('add_hall_detail') }}">
                    @csrf
                    <ul class="conf-step__selectors-box">
                        @foreach($halls as $hall)
                            <li>
                                <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall->id }}" @if($selectedHallId == $hall->id) checked @endif>
                                <span class="conf-step__selector">{{ $hall->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
                    <div class="conf-step__legend">
                        <label class="conf-step__label">Рядов, шт<input name="rows" type="text" class="conf-step__input" placeholder="10" ></label>
                        <span class="multiplier">x</span>
                        <label class="conf-step__label">Мест, шт<input name="seats_per_row" type="text" class="conf-step__input" placeholder="8" ></label>
                        <button type="submit" class="conf-step__button" style="margin-left: 20px;color: #FFFFFF;background-color: #16A6AF;padding: 12px 32px;">Применить</button>
                    </div>
                </form>

                <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
                <div class="conf-step__legend">
                    <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                    <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                    <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                    <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
                </div>

                <form method="post" action="{{ route('add_seats', $selectedHallId) }}">
                    @csrf
                    <div class="conf-step__hall">
                        <div class="conf-step__hall-wrapper">
                            @foreach($halls as $hall)
                                @if($selectedHallId == $hall->id)
                                    @for($i = 0; $i < $hall->rows; $i++)
                                        <div class="conf-step__row">
                                            @for($j = 0; $j < $hall->seats_per_row; $j++)
                                                <input name="seats[{{ $i }}][{{ $j }}][standart]" value="{{ $i . ',' . $j }}" class="conf-step__chair conf-step__chair_standart" data-i="{{ $i }}" data-j="{{ $j }}">
                                            @endfor
                                        </div>
                                    @endfor
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <fieldset class="conf-step__buttons text-center">
                        <button class="conf-step__button conf-step__button-regular">Отмена</button>
                        <input type="submit" value="Сохранить" class="conf-step__button" style="margin-left: 20px;color: #FFFFFF;background-color: #16A6AF;padding: 12px 32px;">
                    </fieldset>
                </form>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Конфигурация цен</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                <ul class="conf-step__selectors-box">
                    <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 1"><span class="conf-step__selector">Зал 1</span></li>
                    <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 2" checked><span class="conf-step__selector">Зал 2</span></li>
                </ul>

                <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
                <div class="conf-step__legend">
                    <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" ></label>
                    за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
                </div>
                <div class="conf-step__legend">
                    <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" value="350"></label>
                    за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
                </div>

                <fieldset class="conf-step__buttons text-center">
                    <button class="conf-step__button conf-step__button-regular">Отмена</button>
                    <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                </fieldset>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Сетка сеансов</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">
                    <button class="conf-step__button conf-step__button-accent" data-target="#popup-add_movie">Добавить фильм</button>
                </p>
                <div class="conf-step__movies">
                    <div class="conf-step__movie" data-target="#popup-add_showtime">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                        <h3 class="conf-step__movie-title">Звёздные войны XXIII: Атака клонированных клонов</h3>
                        <p class="conf-step__movie-duration">130 минут</p>
                    </div>

                    <div class="conf-step__movie" data-target="#popup-add_showtime">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                        <h3 class="conf-step__movie-title">Миссия выполнима</h3>
                        <p class="conf-step__movie-duration">120 минут</p>
                    </div>

                    <div class="conf-step__movie" data-target="#popup-add_showtime">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                        <h3 class="conf-step__movie-title">Серая пантера</h3>
                        <p class="conf-step__movie-duration">90 минут</p>
                    </div>

                    <div class="conf-step__movie" data-target="#popup-add_showtime">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                        <h3 class="conf-step__movie-title">Движение вбок</h3>
                        <p class="conf-step__movie-duration">95 минут</p>
                    </div>

                    <div class="conf-step__movie" data-target="#popup-add_showtime">
                        <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                        <h3 class="conf-step__movie-title">Кот Да Винчи</h3>
                        <p class="conf-step__movie-duration">100 минут</p>
                    </div>
                </div>

                <div class="conf-step__seances">
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">Зал 1</h3>
                        <div class="conf-step__seances-timeline">
                            <button class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 0;" data-target="#popup-delete_showtime">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">00:00</p>
                            </button>
                            <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">12:00</p>
                            </div>
                            <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                                <p class="conf-step__seances-movie-start">14:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="conf-step__seances-hall">
                        <h3 class="conf-step__seances-title">Зал 2</h3>
                        <div class="conf-step__seances-timeline">
                            <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                                <p class="conf-step__seances-movie-start">19:50</p>
                            </div>
                            <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                                <p class="conf-step__seances-movie-start">22:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <fieldset class="conf-step__buttons text-center">
                    <button class="conf-step__button conf-step__button-regular">Отмена</button>
                    <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                </fieldset>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Открыть продажи</h2>
            </header>
            <div class="conf-step__wrapper text-center">
                <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
                <button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
            </div>
        </section>
    </main>

@endsection

