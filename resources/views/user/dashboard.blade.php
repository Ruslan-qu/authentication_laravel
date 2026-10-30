@extends('layouts.main')

@section('title', 'Личный кабинет')

@section('content')
<div class="table-responsive text-center pt-4">
    <table class="table table-hover table-striped-columns table-sm align-middle 
        border-info shadow p-3 mb-5 bg-body-tertiary rounded">
        <thead class="table-secondary">


            <tr>
                <th scope="col1">Имя</th>
                <th scope="col2">Email</th>
                <th scope="col3">Должность</th>
                <th scope="col4">Редактировать</th>
                <th scope="col5">Удалить профиль</th>
            </tr>


        </thead>
        <tbody class="table-group-divider">

            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td><a href="{{ route ('user.edit', ['user' => $user]) }}"
                        class="btn btn-outline-secondary">Изменить</a></td>
                <td><a href="" class="btn btn-outline-danger">Удалить</a></td>
            </tr>

        </tbody>
    </table>
</div>
@endsection