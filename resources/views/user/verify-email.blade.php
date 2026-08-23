@extends('layouts.main')

@section('title', 'Подтвердите Email')

@section('content')

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-3 fw-bold">Подтвердите свой адрес электронной почты</h2>

                    <p class="card-text text-muted mb-4">
                        Мы отправили ссылку для подтверждения на ваш email.
                        Пожалуйста, перейдите по ней, чтобы активировать учетную запись и получить доступ ко всем
                        функциям.
                    </p>

                    <div class="d-grid gap-2 mb-3">
                        <a href="#" target="_blank" class="btn btn-primary btn-lg">Открыть папку
                            «Входящие»</a>
                    </div>

                    <div>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none fw-semibold">Отправить новую
                                ссылку для подтверждения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection