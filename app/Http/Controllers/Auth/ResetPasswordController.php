<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Форма ввода нового пароля
     */
    public function form($token, $email) {
        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Установка нового пароля
     */
    public function reset(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // удаляем старые записи из таблицы сброса паролей
        $expire = Carbon::now()->subMinute(60);
        DB::table('password_resets')
            ->where('created_at', '<', $expire)
            ->delete();
        // если ссылка на восстановление была отправлена
        $row = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();
        // если ссылка уже устарела, то ничего не делаем
        if(!$row) {
            return back()->withErrors('Ссылка восстановления пароля устарела');
        }
        // устанавливаем новый пароль для пользователя
        User::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);
        // удаляем пользователя из таблицы сброса паролей
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Ваш пароль был успешно изменен');
    }
}
