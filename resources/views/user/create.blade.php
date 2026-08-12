@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
<div class="row justify-content-center">

    <div class="col-5">
        <h1 class="text-center">Регистрация</h1>
        <form action="{{ route ('user.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Имя">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                    placeholder="Подтвердите пароль">
            </div>

            <div class="mb-3 form-check">
                <input name="remember" type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрировать</button>

        </form>
    </div>
</div>

@endsection