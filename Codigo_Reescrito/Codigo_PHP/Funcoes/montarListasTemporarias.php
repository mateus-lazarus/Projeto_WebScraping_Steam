<?php

require '.\Config.php';

function montarListasTemporarias() : array
{
    global $enderecoDaPasta;

    $arquivoUm = file_get_contents("$enderecoDaPasta\\Webdriver_1-Temporario.txt");
    $listaUm = json_decode($arquivoUm);
    unlink("$enderecoDaPasta\\Webdriver_1-Temporário.txt");

    $arquivoDois = file_get_contents("$enderecoDaPasta\\Webdriver_2-Temporario.txt");
    $listaDois = json_decode($arquivoDois);
    unlink("$enderecoDaPasta\\Webdriver_2-Temporario.txt");


    foreach ($listaUm as $value) {
        if (in_array($value, $listaDois) == false) {
            array_push($listaDois, $value);
        }
    }

    $listaFinal = $listaDois;
    return $listaFinal;
}