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
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Имя" value="{{ old('name') }}">
            </div>
            @error('name')
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

            <button type="submit" class="btn btn-primary">Зарегистрировать</button>

        </form>
    </div>
</div>

@endsection