<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class DadosEstatisticos extends Model
{
    // Nome da tabela
    protected $table = 'dadosEstatisticos';

    // Nome do ID
    protected $primaryKey = 'id';
    // ID será AI (auto generate)
    public $increment = true;

    // Colunas da tabela
    protected $fillable = [
        // Nenhum dado é passível de ser alterado por enquanto
        // 'created_at',
        // 'jogosCadastrados',
        // 'leBundles',
        // 'tempoDeExecucao',
        // 'SegundosporJogo',
    ];
}
