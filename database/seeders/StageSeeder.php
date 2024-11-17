<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stage::insert([
            [
                'desc' => 'Agendado',
                'code' => 01,
                'position' => 0,
            ],
            [
                'desc' => 'Checkin',
                'code' => 02,
                'position' => 1,
            ],
            [
                'desc' => 'Entrou na Planta',
                'code' => 03,
                'position' => 2,
            ],
            [
                'desc' => 'Iniciou Operação',
                'code' => 04,
                'position' => 3,
            ],
            [
                'desc' => 'Finalizou Operação',
                'code' => 05,
                'position' => 4,
            ],
            [
                'desc' => 'Saiu da Planta',
                'code' => 06,
                'position' => 5,
            ],
            [
                'desc' => 'Cancelado',
                'code' => 99,
                'position' => 99,
            ],
        ]);
    }
}
