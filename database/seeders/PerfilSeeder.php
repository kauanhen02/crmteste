<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilSeeder extends Seeder
{
    public function run()
    {
        if (count(Perfil::get()) == 0) {
            Perfil::create([
                'descricao' => 'Perfil A',
            ]);
    
            Perfil::create([
                'descricao' => 'Perfil B',
            ]);
    
            Perfil::create([
                'descricao' => 'Perfil C',
            ]);
        }
    }
}
