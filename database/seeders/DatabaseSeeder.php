<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
\App\Models\User::factory()->count(10)->create();

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
            'role' => 'medico', // Ojo: Asegúrate de usar siempre 'medico' o 'doctor' consistentemente
        ]);

        // Crear la ficha del doctor asociada
        Doctor::create([
            'user_id' => $userDoctor->id, // Aquí usamos el ID del usuario recién creado
            'especialidad' => 'Traumatologia', // Coincide con tu migración 'doctors'
        ]);

        // 3. Crear PACIENTE (Usuario + Perfil Paciente)
        $userPaciente = User::create([
            'name' => 'Carlos',
            'email' => 'abigailwiracocha@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'paciente',
        ]);

        // Crear la ficha del paciente asociada
        Patient::create([
            'user_id' => $userPaciente->id, // Vinculamos con el usuario Carlos
            'edad' => 30,
            'sexo' => 'Masculino', // Coincide con tu migración 'patients'
        ]);
        
        // (Opcional) Crear más datos falsos si tienes factories
        // User::factory(10)->create();
    }
}
