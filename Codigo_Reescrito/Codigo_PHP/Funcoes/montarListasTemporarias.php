<?php

require '.\Config.php';

function montarListasTemporarias() : array
{
    global $enderecoDaPasta;

    $listaFinal = [];

    $arquivoUm = file_exists("$enderecoDaPasta\\Webdriver_1-Temporario.txt");
    $arquivoDois = file_exists("$enderecoDaPasta\\Webdriver_2-Temporario.txt");
    
    switch ([$arquivoUm, $arquivoDois]):
        case [true, true]:
            unset($arquivoUm);
            unset($arquivoDois);
            break;
        case [true, false]:
            throw new ErrorException('arquivo Webdriver_2 não existe.');
            exit();
        case [false, true]:
            throw new ErrorException('arquivo Webdriver_1 não existe.');
            exit();
        case [false, false]:
            throw new ErrorException('Nenhum arquivo foi encontrando.');
            exit();
    endswitch;


    $arquivoUm = file_get_contents("$enderecoDaPasta\\Webdriver_1-Temporario.txt");
    $listaUm = json_decode($arquivoUm);
    // unlink("$enderecoDaPasta\\Webdriver_1-Temporario.txt");

    $arquivoDois = file_get_contents("$enderecoDaPasta\\Webdriver_2-Temporario.txt");
    $listaDois = json_decode($arquivoDois);
    // unlink("$enderecoDaPasta\\Webdriver_2-Temporario.txt");


    foreach ($listaUm as $value) {
        if (in_array($value, $listaFinal) == false) {
            array_push($listaFinal, $value);
        }
    };

    foreach ($listaDois as $value) {
        if (in_array($value, $listaFinal) == false) {
            array_push($listaFinal, $value);
        }
    };


    return $listaFinal;
}