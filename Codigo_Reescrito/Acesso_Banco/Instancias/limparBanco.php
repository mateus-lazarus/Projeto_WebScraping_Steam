<?php


namespace Banco\Instancias;


use PDO;


trait LimparBanco
{
    public function limparSchema() : void
    {
        $this->conexao->exec("
            TRUNCATE {$this->schemaNome}.{$this->tableNome};
        ");
    }
}
