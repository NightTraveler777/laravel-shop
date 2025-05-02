<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Форма регистрации
     */
    public function register() {
        return view('auth.register');
    }

    /**
     * Добавление пользователя
     */
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // ссылка для проверки адреса почты
        $token = md5($user->email . $user->name);
        $link = route('auth.verify-email', ['token' => $token, 'id' => $user->id]);
        Mail::send(
            'email.verify-email',
            ['link' => $link],
            function($message) use ($request) {
                $message->to($request->email);
                $message->subject('Подтверждение адреса почты');
            }
        );

        // необходимо подтвердить адрес почты
        return redirect()->route('auth.verify-message');

        /*session()->flash('success', 'Регистрация пройдена');
        Auth::login($user);
        return redirect()->route('auth.login');*/
    }
}
