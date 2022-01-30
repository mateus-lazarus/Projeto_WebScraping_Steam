<?php

namespace Banco\Persistente;


require_once __DIR__ . '/../Config.php';

use Configuracoes;
use PDO;


class Conexao
{
    protected PDO $conexao;

    use Configuracoes;      // Informações de configuração da conexão

    public function __construct()
    {
        $dadosConexao = "$this->tipo:host:$this->url;dbname=$this->schemaNome";
        $this->conexao = new PDO($dadosConexao, $this->usuario, $this->senha);
    }
}
