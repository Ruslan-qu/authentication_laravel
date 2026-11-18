<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ValidStoreUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidStoreUserRequest $validStoreUserRequest)
    {

        $user = User::create($validStoreUserRequest->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('user.dashboard', ['user' => Auth::user()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        return view('user.edit', [
            'user' => Auth::user(),
            'roles' => Role::all() // При изменение количества роллей измените edit.blade и AppServiceProvider.
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateUserRequest $updateUserRequest,
        User $user,
        UserService $userService
    ) {

        $user->fill($updateUserRequest->safe()->input());

        if (!$user->isDirty()) {
            return back()->with('status', 'Нет изменений');
        }

        $edited_user = $userService->update($updateUserRequest, $user);
        
        if ($user->wasChanged('email')) {
            event(new Registered($user));
            return redirect()->route('verification.notice');
        }

//dd(1);
        return back()->with('status', 'Данные обновлены успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
