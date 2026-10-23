@extends('layouts.main')

@section('title', 'Личный кабинет')

@section('content')
<div class="table-responsive text-center pt-4">
    <table class="table table-bordered table-hover table-striped-columns table-sm align-middle 
        border-info shadow p-3 mb-5 bg-body-tertiary rounded">
        <thead class="table-secondary">


            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Email</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Удалить профиль</th>
            </tr>


        </thead>
        <tbody class="table-group-divider">


            <tr>
                <td></td>
                <td></td>
                <form action="" name="edit_participant_personal_account">

                    <td><button class="btn btn-outline-secondary" type="submit" name="id"
                            value="">Изменить</button></td>

                </form>
                <form action="" name="delete_participant_personal_account">

                    <td><button class="btn btn-outline-danger" type="submit" name="id"
                            value="">Удалить</button></td>

                </form>
            </tr>

        </tbody>
    </table>
</div>
@endsection