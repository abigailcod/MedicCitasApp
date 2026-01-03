<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. Crear DOCTOR (Usuario + Perfil Doctor)
        $userDoctor = User::create([
            'name' => 'Dr Juan',
            'email' => 'espinozaabigail2006@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'medico',
        ]);

        Doctor::create([
            'user_id' => $userDoctor->id,
            'especialidad' => 'Traumatologia',
        ]);

        // 3. Crear PACIENTE (Usuario + Perfil Paciente)
        $userPaciente = User::create([
            'name' => 'Carlos',
            'email' => 'abigailwiracocha@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'paciente',
        ]);

        Patient::create([
            'user_id' => $userPaciente->id,
            'edad' => 30,
            'sexo' => 'Masculino',
        ]);
        
        // (Opcional) Crear más datos falsos si tienes factories
        User::factory(10)->create();
    }
}
