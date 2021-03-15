<?php

use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'nome' => 'Comum',
                'sigla' => 'CMM'
            ],
            [
                'nome' => 'Logista',
                'sigla' => 'LJT'
            ]
        ];

        foreach($tipos as $tipo)
        {
            TipoUsuario::firstOrCreate([
                'sigla' => $tipo['sigla']
            ], [
                'nome' => $tipo['nome']
            ]);
        }
    }
}
