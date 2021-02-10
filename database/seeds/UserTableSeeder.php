<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $administrador_role = Role::where('name', 'administrador')->first();
        $recepcionista_role = Role::where('name', 'recepcionista')->first();
        // $especialista_role = Role::where('name', 'especialista')->first();

        $administrador_user = User::create([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $administrador_role->id,
            'hospital_id' => 1
        ]);

        $recepcionista_user = User::create([
            'name' => 'Francisco',
            'last_name' => 'Hormazabal',
            'email' => 'f.hormazabal@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $recepcionista_role->id,
            'hospital_id' => 1
        ]);

    }
}
