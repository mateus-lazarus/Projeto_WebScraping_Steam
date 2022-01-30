<?php

namespace Banco\Persistente;


require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../Instancias/inserirBanco.php';
require_once __DIR__ . '/../Instancias/limparBanco.php';

use Banco\Instancias\InserirBanco;
use Banco\Instancias\LimparBanco;


final class Controlador extends Conexao
{
    use InserirBanco;
    use LimparBanco;
}