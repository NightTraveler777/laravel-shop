<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-roles')->only('index');
        $this->middleware('perm:create-role')->only(['create', 'store']);
        $this->middleware('perm:edit-role')->only(['edit', 'update']);
        $this->middleware('perm:delete-role')->only('destroy');
    }

    /**
     * Показывает список всех ролей пользователя
     */
    public function index() {
        $roles = Role::paginate(8);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Показывает форму для создания роли
     */
    public function create() {
        $allperms = Permission::all();
        return view('admin.roles.create', compact('allperms'));
    }

    /**
     * Сохраняет новую роль в базу данных
     */
    public function store(Request $request) {
        $this->validator($request->all(), null)->validate();
        $role = Role::create($request->all());
        $role->permissions()->attach($request->perms ?? []);
        return redirect()
            ->route('role.index')
            ->with('success', 'Новая роль успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Показывает форму для редактирования роли
     */
    public function edit(Role $role) {
        $allperms = Permission::all();
        return view('admin.roles.edit', compact('role', 'allperms'));
    }

    /**
     * Обновляет роль в базе данных
     */
    public function update(Request $request, Role $role) {
        if ($role->id === 4) {
            return redirect()
                ->route('role.index')
                ->withErrors('Эту роль нельзя редактировать');
        }
        $this->validator($request->all(), $role->id)->validate();
        if (in_array($role->id, [5, 6])) {
            $role->update($request->except('slug'));
        } else {
            $role->update($request->all());
        }
        $role->permissions()->sync($request->perms ?? []);
        return redirect()
            ->route('role.index')
            ->with('success', 'Роль была успешно отредактирована');
    }

    /**
     * Удаляет роль из базы данных
     */
    public function destroy(Role $role) {
        if (in_array($role->id, [4, 5, 6])) {
            return redirect()
                ->route('role.index')
                ->withErrors('Эту роль нельзя удалить');
        }
        $role->delete();
        return redirect()
            ->route('role.index')
            ->with('success', 'Роль была успешно удалена');
    }

    /**
     * Возвращает объект валидатора с нужными правилами
     */
    private function validator($data, $id) {
        $unique = 'unique:roles,slug';
        if ($id) {
            // проверка на уникальность slug роли при редактировании,
            // исключая эту роль по идентифкатору в таблице БД roles
            $unique = 'unique:roles,slug,'.$id.',id';
        }
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'slug' => [
                'required',
                'max:50',
                $unique,
                'regex:~^[-_a-z0-9]+$~i',
            ]
        ];
        $messages = [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'max' => 'Поле «:attribute» должно быть не больше :max символов',
        ];
        $attributes = [
            'name' => 'Наименование',
            'slug' => 'Идентификатор'
        ];
        return Validator::make($data, $rules, $messages, $attributes);
    }
}
