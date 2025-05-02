<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RoleTableSeeder::class);
        $this->command->info('Таблица ролей загружена данными!');

        $this->call(PermissionTableSeeder::class);
        $this->command->info('Таблица прав загружена данными!');

        $this->call(RolePermissionTableSeeder::class);
        $this->command->info('Таблица роль-право загружена данными!');

        $this->call(UserPermissionTableSeeder::class);
        $this->command->info('Таблица пользователь-право загружена данными!');

        $this->call(UserRoleTableSeeder::class);
        $this->command->info('Таблица пользователь-роль загружена данными!');
    }
}
