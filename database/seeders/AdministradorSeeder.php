<?php

namespace Database\Seeders;

use App\Models\Administrador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrador::create([
            'correo' => 'admin1@mail.com',
            'contraseña' => 'admin123',
        ]);

        Administrador::create([
            'correo' => 'admin2@mail.com',
            'contraseña' => 'admin456',
        ]);
    }
}
