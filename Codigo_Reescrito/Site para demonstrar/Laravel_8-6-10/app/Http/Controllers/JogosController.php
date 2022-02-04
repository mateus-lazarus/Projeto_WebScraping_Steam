<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

// A Entidade de jogos cadastrados no banco
use App\Models\Jogo;
use App\Models\DadosEstatisticos;


class JogosController extends BaseController
{
    public function ordemCrescente(Request $request)
    {
        return view( //'welcome',
            view: 'paginas.exibirJogos',
            data: [
                'listaDeJogos' => Jogo::query()
                    ->orderBy('jogo_precoDepois', 'asc')
                    ->get(),
                
                'dadosEstatisticos' => DadosEstatisticos::all()
            ]
        );

    }

    public function ordemDecrescente(Request $request)
    {
        return view(
            view: 'paginas.exibirJogos',
            data: [
                'listaDeJogos' => Jogo::query()
                    ->orderBy('jogo_precoDepois', 'desc')
                    ->get(),

                'dadosEstatisticos' => DadosEstatisticos::all()
            ]
        );
        
    }
}
