<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once '.\Config.php';
require_once 'rolarPagina.php';
require_once 'listarJogos.php';


function lerPagina(RemoteWebDriver $webdriver) : array
{
    global $descontoMinimo;


    $XPath_search_results = '//*[@id="search_resultsRows"]';

    $numeroJogosLidos = rolarPagina($webdriver, $XPath_search_results);
    echo "Foram lidos $numeroJogosLidos jogos." . PHP_EOL;

    return listarJogos($numeroJogosLidos, $descontoMinimo, $XPath_search_results, $webdriver);
}