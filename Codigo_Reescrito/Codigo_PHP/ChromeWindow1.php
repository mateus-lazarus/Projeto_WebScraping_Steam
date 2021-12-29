<?php

/*
    Processo chrome aberto independentemente para permitir "burlar" o GIL do Python e utilizar de multiprocesamento 
        para acelerar a pesquisa.
    
*/


require 'Codigo_Reescrito\Codigo_PHP\Config.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;



$nomeInstancia = $instanciaUm;

$serverUrl = 'http://localhost:4441';
$webdriver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

$linkDaPagina = new SteamTags();
$linkDaPagina = $linkDaPagina->linkComTag($linkDaPagina->multiplayer, $valorMaximo);

$webdriver->get($linkDaPagina);

$listaBonsJogos = lerPagina($webdriver);

escreverListaTemporaria($listaBonsJogos, $nomeInstancia);