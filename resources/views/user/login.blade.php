@extends('layouts.main')

@section('title', 'Вход')

@section('content')
<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">
        <h1 class="text-center">Вход</h1>
        <form action="{{ route ('authorization.user') }}" method="post">

            @csrf

            @error('errorAuthorization')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-2">
                <label for="email" class="form-label mb-0">Email</label>
                <input name="email" type="email" class="form-control" id="email"
                    placeholder="Email">
            </div>

            <div class="mb-2">
                <label for="password" class="form-label mb-0">Пароль</label>
                <input name="password" type="password" class="form-control"
                    id="password" placeholder="Пароль">
            </div>

            <div class="mb-2">
                <label for="registration_index" class="form-label mb-0">Индекс регистрации</label>
                <input
                    name="registration_index"
                    type="registration_index"
                    class="form-control @error('registration_index') is-invalid @enderror"
                    id="registration_index"
                    placeholder="Индекс"
                    value="{{ old('registration_index') }}">
            </div>

            <div class="mb-3 form-check">
                <input name="remember" class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label" for="remember">
                    Запомнить меня
                </label>
            </div>

            <button type="submit" class="btn btn-danger w-50">Вход</button>

            <a href="{{ route('password.request') }}" class="link-primary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover ms-3">Забыл пароль?</a>

        </form>
    </div>
</div>
@endsection