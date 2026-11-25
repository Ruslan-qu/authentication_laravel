@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">
        <h1 class="text-center fs-2">Регистрация</h1>
        <form action="{{ route ('user.store') }}" method="post">

            @csrf

            <div class="mb-2">
                <label for="name" class="form-label mb-0">Имя</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Имя" value="{{ old('name') }}">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-2">
                <label for="email" class="form-label mb-0">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="Email" value="{{ old('email') }}">
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-2">
                <label for="password" class="form-label mb-0">Пароль</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" placeholder="Пароль">
            </div>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-2">
                <label for="password_confirmation" class="form-label mb-0">Подтвердите
                    пароль</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                    placeholder="Подтвердите пароль">
            </div>

            <div>
                <label for="registration_index" class="form-label mb-0">Индекс регистрации</label>
                <input
                    name="registration_index"
                    type="registration_index"
                    class="form-control @error('registration_index') is-invalid @enderror"
                    id="registration_index"
                    placeholder="Индекс"
                    value="{{ old('registration_index') }}">
            </div>
            <div>
                <p class="small">
                    Админ: придумайте индекс.<br>
                    Пользователь: введите индекс админа.
                </p>
            </div>
            @error('registration_index')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary w-100">Зарегистрировать</button>

        </form>
    </div>
</div>

@endsection