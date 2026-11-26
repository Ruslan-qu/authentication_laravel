<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ValidStoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
    public function store(ValidStoreUserRequest $request)
    {
        
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        
        $user->registration_index = $request->registration_index;
        $exists = User::where('registration_index', $request->registration_index)->exists();
        if ($exists == true) {
            $user->role_id = 1;
        }
        if ($exists == false) {
            $user->is_active = true;
        }

        //$user->save();

        //event(new Registered($user));

        //Auth::login($user);

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
    public function edit(Request $request, User $user)
    {
        if (! Gate::allows('admin-panel')) {
            abort_if($request->user()->isNot($user), 403);
        }

        return view('user.edit', [
            'user' => $user,
            'roles' => Role::all() // При изменение количества роллей измените edit.blade и AppServiceProvider.
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateUserRequest $request,
        User $user,
    ): RedirectResponse {

        $user->fill($request->validated());

        if ($user->isClean()) {
            return back()->with('status', 'Нет изменений');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user->wasChanged('email')
            ? to_route('verification.notice')
            : back()->with('status', 'Данные обновлены успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('register')->with('status', 'Аккаунт успешно удален');
    }
}
