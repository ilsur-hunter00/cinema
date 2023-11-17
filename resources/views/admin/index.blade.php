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
                @if($errors->has('hall_name'))
                    <div class="alert alert-danger">{{ $errors->first('hall_name') }}</div>
                @endif
                <p class="conf-step__paragraph">Доступные залы:</p>
                <ul class="conf-step__list">
                    @foreach($halls as $hall)
                        <li>{{ $hall->name }}
                            <form id="deleteHallForm" method="POST" action="{{ route('delete_hall', $hall->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="conf-step__button-trash" onclick="return confirm('Вы уверены, что хотите удалить этот зал?')" style="border: none"></button>
                            </form>
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
                    @if ($errors->has('rows') || $errors->has('seats_per_row'))
                        <div class="conf-step__error alert-danger">
                            <p>{{ $errors->first('rows') }}</p>
                            <p>{{ $errors->first('seats_per_row') }}</p>
                        </div>
                    @endif
                    <div class="conf-step__legend">
                        <label class="conf-step__label">Рядов, шт<input name="rows" type="text" class="conf-step__input" value="{{ $halls->where('id', $selectedHallId)->first()->rows ?? '' }}" placeholder="10"></label>
                        <span class="multiplier">x</span>
                        <label class="conf-step__label">Мест, шт<input name="seats_per_row" type="text" class="conf-step__input" value="{{ $halls->where('id', $selectedHallId)->first()->seats_per_row ?? '' }}" placeholder="8" ></label>
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
                                                {{$seatStatus = $seatStatuses->where('row_number', $i)->where('seat_number', $j)->first()->type ?? 'standart'}}
                                                <input name="seats[{{ $i }}][{{ $j }}][{{$seatStatus}}]" value="{{ $i . ',' . $j }}" class="conf-step__chair conf-step__chair_{{$seatStatus}}" data-i="{{ $i }}" data-j="{{ $j }}">
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
                <form method="post" action="{{ route('set_price', $selectedHallId) }}">
                    @csrf
                    <ul class="conf-step__selectors-box">
                        @foreach($halls as $hall)
                            <li>
                                <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall->id }}" @if($selectedHallId == $hall->id) checked @endif>
                                <span class="conf-step__selector">{{ $hall->name }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
                    @if ($errors->has('standart-chair') || $errors->has('vip-chair'))
                        <div class="conf-step__error alert-danger">
                            <p>{{ $errors->first('standart-chair') }}</p>
                            <p>{{ $errors->first('vip-chair') }}</p>
                        </div>
                    @endif
                    <div class="conf-step__legend">
                        <label class="conf-step__label">Цена, рублей<input type="text" name="standart-chair" class="conf-step__input" placeholder="100" ></label>
                        за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
                    </div>
                    <div class="conf-step__legend">
                        <label class="conf-step__label">Цена, рублей<input type="text" name="vip-chair" class="conf-step__input" placeholder="350"></label>
                        за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
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
                <h2 class="conf-step__title">Сетка сеансов</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">
                    <button class="conf-step__button conf-step__button-accent" data-target="#popup-add_movie">Добавить фильм</button>
                </p>
                @if ($errors->has('movie-name') || $errors->has('movie-duration') || $errors->has('movie-description'))
                    <div class="conf-step__error alert-danger">
                        <p>{{ $errors->first('movie-name') }}</p>
                        <p>{{ $errors->first('movie-duration') }}</p>
                        <p>{{ $errors->first('movie-description') }}</p>
                    </div>
                @endif
                <div class="conf-step__movies">
                    @foreach($movies as $movie)
                        <div class="conf-step__movie" data-target="#popup-add_showtime">
                            <img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin/images/poster.png') }}">
                            <h3 class="conf-step__movie-title">{{ $movie->title }}</h3>
                            <p class="conf-step__movie-duration">{{ $movie->duration }} минут</p>
                        </div>
                    @endforeach
                </div>

                <div class="conf-step__seances">
                    @foreach($halls as $hall)
                        <div class="conf-step__seances-hall">
                            <h3 class="conf-step__seances-title">{{ $hall->name }}</h3>
                            <div class="conf-step__seances-timeline">
                                @foreach($screenings as $screening)
                                    @if($hall->id == $screening->cinemaHall->id)
                                        <button class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137)" data-target="#popup-delete_showtime" data-screening-id="{{ $screening->id }}">
                                            <p class="conf-step__seances-movie-title">{{ $screening->movie->title }}</p>
                                            <p class="conf-step__seances-movie-start">{{ (new DateTime($screening->start_time))->format('H:i') }}</p>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="conf-step">
            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Открыть продажи</h2>
            </header>
            <div class="conf-step__wrapper text-center">
                @if(!\App\Models\User::query()->where('name', 'admin')->first()->is_opened_sells)
                    <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
                    <form action="{{ route('open_sells') }}" method="post">
                        @csrf
                        <button type="submit" class="conf-step__button" style="margin-left: 20px;color: #FFFFFF;background-color: #16A6AF;padding: 12px 32px;">Открыть продажу билетов</button>
                    </form>
                @endif
            </div>
        </section>
    </main>

@endsection

