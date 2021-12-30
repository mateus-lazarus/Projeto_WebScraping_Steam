<?php

require_once '.\Config.php';

function escreverListaTemporaria(array $listaJogosBons, string $nomeInstancia) : void
{
    global $enderecoDaPasta;
    
    $acessoArquivo = "$enderecoDaPasta\\$nomeInstancia-Temporario.txt";

    $arquivo = fopen($acessoArquivo, 'w');
    fwrite($arquivo, json_encode($listaJogosBons));
    fclose($arquivo);
}