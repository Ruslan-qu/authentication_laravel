@extends('layouts.main')

@section('title', 'Сменить пароль')

@section('content')

<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">

        <h1 class="text-center">Сменить пароль</h1>

        <form action="{{ route ('password.update') }}" method="post">

            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            @error('errorForgotPassword')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

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

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтвердите
                    пароль</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                    placeholder="Подтвердите пароль">
            </div>

            <button type="submit" class="btn btn-danger">Сменить пароль</button>

        </form>
    </div>
</div>
@endsection