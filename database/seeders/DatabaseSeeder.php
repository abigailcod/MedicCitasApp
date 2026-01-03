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
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );
        
        // Asegurar rol de admin (por si el usuario ya existía con otro rol)
        if ($admin->role !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }

        // 2. Crear DOCTOR (Usuario + Perfil Doctor)
        $userDoctor = User::firstOrCreate(
            ['email' => 'espinozaabigail2006@gmail.com'],
            [
                'name' => 'Dr Juan',
                'password' => bcrypt('password123'),
                'role' => 'medico',
            ]
        );

        if ($userDoctor->role !== 'medico') {
            $userDoctor->role = 'medico';
            $userDoctor->save();
        }

        Doctor::firstOrCreate(
            ['user_id' => $userDoctor->id],
            [
                'especialidad' => 'Traumatologia',
            ]
        );

        // 3. Crear PACIENTE (Usuario + Perfil Paciente)
        $userPaciente = User::firstOrCreate(
            ['email' => 'abigailwiracocha@gmail.com'],
            [
                'name' => 'Carlos',
                'password' => bcrypt('password123'),
                'role' => 'paciente',
            ]
        );

        if ($userPaciente->role !== 'paciente') {
            $userPaciente->role = 'paciente';
            $userPaciente->save();
        }

        Patient::firstOrCreate(
            ['user_id' => $userPaciente->id],
            [
                'edad' => 30,
                'sexo' => 'Masculino',
            ]
        );
        
        // (Opcional) Crear más datos falsos si tienes factories
        // Comentamos esto para evitar crear usuarios extra en cada deploy si no es intencional
        // User::factory(10)->create();
    }
}
