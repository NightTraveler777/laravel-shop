<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Форма входа в личный кабинет
     */
    public function login() {
        return view('auth.login');
    }

    /**
     * Аутентификация пользователя
     */
    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->has('remember'))) {
            if (Auth::user()->role == 'root' || Auth::user()->role == 'admin') {
                session()->flash('success', 'Вы авторизовались');
                return redirect()->route('admin.index');
            } else {
            /**
             * Адрес почты не подтвержден
             */
                if (is_null(Auth::user()->email_verified_at)) {
                    Auth::logout();
                    return redirect()
                        ->route('auth.verify-message')
                        ->withErrors('Адрес почты не подтвержден');
                }
                session()->flash('success', 'Вы авторизовались');
                return redirect()->route('user.index');
            }
        }

        return redirect()->back()->with('error', 'Не верный логин или пароль');
    }

    /**
     * Выход из личного кабинета
     */
    public function logout() {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
