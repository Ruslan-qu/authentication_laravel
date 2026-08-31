@extends('layouts.main')

@section('title', 'Восстановление пароля')

@section('content')

<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">

        <h1 class="text-center">Восстановление пароля</h1>

        <form action="{{ route ('password.email') }}" method="post">

            @csrf

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

            <button type="submit" class="btn btn-danger">Отправить</button>

        </form>
    </div>
</div>
@endsection