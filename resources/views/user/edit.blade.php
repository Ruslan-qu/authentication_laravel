@extends('layouts.main')

@section('title', 'Редактировать профиль')

@section('content')
<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">
        <h1 class="text-center">Редактировать профиль</h1>
        <form action="{{ route ('user.update', ['user' => $user]) }}" method="post">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Имя" value="{{ $user->name }}">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="email" value="{{ $user->email }}">
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-field">
                <label for="role_id" class="form-label">Должность</label>
                <select class="form-control" id="role_id">
                    @foreach ($roles as $role)
                    @can('select-roles-1', $role)
                    <option value="1" selected>Пользователь</option>
                    @endcan
                    @can('select-roles-2', $role)
                    <option value="1">Пользователь</option>
                    <option value="2" selected>Админ</option>
                    @endcan
                    @can('select-roles-3', $role)
                    <option value="1">Пользователь</option>
                    <option value="2">Админ</option>
                    <option value="3" selected>Босс</option>
                    @endcan
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" placeholder="Пароль">
            </div>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary">Зарегистрировать</button>

        </form>
    </div>
</div>

@endsection