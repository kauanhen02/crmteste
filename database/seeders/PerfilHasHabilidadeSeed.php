<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Habilidade;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfilHasHabilidadeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (count(User::get()) == 0) {
            $grupos = Perfil::get();
            $habilidades = Habilidade::get()->pluck('id');

            foreach ($grupos as $key => $value) {
                $value->habilidades()->detach();

                $value->habilidades()->attach($habilidades);
            }
        }
    }
}
