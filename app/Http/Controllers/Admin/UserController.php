<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-users')->only('index');
        $this->middleware('perm:edit-user')->only(['edit', 'update']);
    }

    /**
     * Показывает список всех пользователей
     */
    public function index() {
        $users = User::with('roles', 'posts', 'comments')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Показывает форму для редактирования пользователя
     */
    public function edit(User $user) {
        $allroles = Role::all();
        $allperms = Permission::all();
        return view('admin.users.edit', compact('user', 'allroles', 'allperms'));
    }

    /**
     * Обновляет данные пользователя в базе данных
     */
    public function update(Request $request, User $user) {
        /**
         * Проверяем данные формы
         */
        $this->validator($request->all(), $user->id)->validate();
        /*
         * Обновляем пользователя
         */
        if ($request->change_password) { // если надо изменить пароль
            $request->merge(['password' => bcrypt($request->password)]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }
        /*
         * Назначаем роли и права
         */
        if (auth()->user()->hasPermAnyWay('assign-role')) {
            $user->roles()->sync($request->roles);
        }
        if (auth()->user()->hasPermAnyWay('assign-permission')) {
            $user->permissions()->sync($request->perms);
        }
        /*
         * Возвращаемся к списку
         */
        return redirect()
            ->route('users.index')
            ->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Возвращает объект валидатора с нужными нам правилами
     */
    private function validator(array $data, int $id) {
        $rules = [
            'name' => [
                'required',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                // проверка на уникальность email, исключая
                // этого пользователя по идентифкатору
                'unique:users,email,'.$id.',id',
            ],
        ];
        if (isset($data['change_password'])) {
            $rules['password'] = ['required', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }
        return Validator::make($data, $rules);
    }
}
