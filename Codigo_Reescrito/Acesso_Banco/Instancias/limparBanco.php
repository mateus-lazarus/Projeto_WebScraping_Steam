<?php


namespace Banco\Instancias;


use PDO;


trait LimparBanco
{
    public function limparSchema() : void
    {
        $this->conexao->exec("
            TRUNCATE {$this->schemaNome}.{$this->tableJogos};
        ");

        $this->conexao->exec("
            TRUNCATE {$this->schemaNome}.{$this->tableDadosEstatisticos};
        ");
    }
}
