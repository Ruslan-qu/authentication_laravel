@extends('layouts.main')

@section('title', 'Вход')

@section('content')
<div class="row justify-content-center">

    <div class="col-5">
        <h1 class="text-center">Вход</h1>
        <form action="{{ route ('user.store') }}" method="post">

            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="email" value="{{ old('email') }}">
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" placeholder="Пароль">
            </div>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3 form-check">
                <input name="remember" class="form-check-input" type="checkbox" value="" id="remember">
                <label class="form-check-label" for="remember">
                    Запомнить меня
                </label>
            </div>

            <button type="submit" class="btn btn-danger">Вход</button>

        </form>
    </div>
</div>
@endsection