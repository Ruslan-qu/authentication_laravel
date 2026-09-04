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

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email"
                    placeholder="email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control"
                    id="password" placeholder="Пароль">
            </div>

            <div class="mb-3 form-check">
                <input name="remember" class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label" for="remember">
                    Запомнить меня
                </label>
            </div>

            <button type="submit" class="btn btn-danger">Вход</button>

            <a href="{{ route('password.request') }}" class="ms-3">Забыл пароль?</a>

        </form>
    </div>
</div>
@endsection