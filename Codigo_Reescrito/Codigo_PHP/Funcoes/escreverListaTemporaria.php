<?php

require 'Codigo_Reescrito\Codigo_PHP\Config.php';

function escreverListaTemporaria(array $listaJogosBons, string $nomeInstancia) : void
{
    global $EnderecoDaPasta;
    
    $arquivo = fopen("$EnderecoDaPasta\\$nomeInstancia-Temporario.txt", 'w');
    fwrite($arquivo, json_encode($listaJogosBons));
    fclose($arquivo);
}