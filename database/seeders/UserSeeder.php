<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ! Usuario Administrador
        $user = User::create([
            'name' => 'Heyner Leiva',
            'email' => 'heynerleiva18@gmail.com',
            'password' => bcrypt('heyner123')
        ]);

        $role = Role::where('name','admin')->first(); // * Obtiene el rol deseado
        $user->roles()->attach($role); // * Asociar el rol al usuario
    }
}
