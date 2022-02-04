<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Jogo extends Model
{
    // Nome da tabela
    protected $table = 'jogos';

    // Nome do ID
    protected $primaryKey = 'jogos_id';
    // ID será AI (auto generate)
    public $increment = true;

    // Colunas da tabela
    protected $fillable = [
        // Nenhum dado é passível de ser alterado por enquanto
        // 'jogo_nome',
        // 'jogo_nivelAvaliacao',
        // 'jogo_precoAntes',
        // 'jogo_precoDepois',
        // 'jogo_desconto',
        // 'jogo_linkJogo',
        // 'jogo_linkVideo',
        // 'jogo_linkFoto',
        // 'jogo_descricao'
    ];

    // Colunas de created_at e updated_at
    public $timestamps = true;
}
