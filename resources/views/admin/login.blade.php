@extends('layouts.admin')

@section('content')

    <main>
        <section class="login">
            <header class="login__header">
                <h2 class="login__title">Авторизация</h2>
            </header>
            <div class="login__wrapper">
                @if($errors->any())
                    <div style="background: red; padding: 10px;">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="login__form" action="{{ route('admin_login') }}" method="post" accept-charset="utf-8">
                    @csrf
                    <label class="login__label" for="email">
                        E-mail
                        <input class="login__input" type="email" placeholder="example@domain.xyz" name="email" required>
                    </label>
                    <label class="login__label" for="pwd">
                        Пароль
                        <input class="login__input" type="password" placeholder="" name="password" required>
                    </label>
                    <div class="text-center">
                        <input value="Авторизоваться" type="submit" class="login__button">
                    </div>
                </form>
            </div>
        </section>
    </main>

@endsection
