<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * * Roles
         * !1. Administrador
         * !2. Editor
         * !3. Autor
         * !4. Colaborador
         * !5. Lector 
         */

        $roles = [
            ['name' => 'admin'],
            ['name' => 'editor'],
            ['name' => 'author'],
            ['name' => 'contributor'],
            ['name' => 'reader'],
        ];

        foreach($roles as $role){
            Role::create($role);
        }

    }
}
