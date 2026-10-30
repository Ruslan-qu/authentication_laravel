@extends('layouts.main')

@section('title', 'Редактировать профиль')

@section('content')
<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">
        <h1 class="text-center">Редактировать профиль</h1>
        <form action="" method="post">

            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Имя" value="{{ $users->name }}">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="email" value="{{ $users->email }}">
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="email" class="form-label">Должность</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="email" value="{{ $users->email }}">
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