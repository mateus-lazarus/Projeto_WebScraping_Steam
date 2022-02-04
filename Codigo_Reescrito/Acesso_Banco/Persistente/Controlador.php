<?php

namespace Banco\Persistente;


require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../Instancias/inserirJogos.php';
require_once __DIR__ . '/../Instancias/inserirDadosEstatisticos.php';
require_once __DIR__ . '/../Instancias/limparBanco.php';

use Banco\Instancias\{
    inserirDadosEstatisticos,
    inserirJogos,
    LimparBanco
};


final class Controlador extends Conexao
{
    use inserirDadosEstatisticos;
    use inserirJogos;
    use LimparBanco;
}