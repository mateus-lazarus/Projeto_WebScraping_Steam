<?php

/*
    Processo chrome aberto independentemente para permitir "burlar" o GIL do Python e utilizar de multiprocesamento 
        para acelerar a pesquisa.
    
*/


require_once 'Config.php';

require_once 'Dependencias/vendor/autoload.php';
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

require_once 'Classes/SteamTags.php';
require_once 'Funcoes/lerPagina.php';
require_once 'Funcoes/escreverListaTemporaria.php';

$nomeInstancia = $instanciaUm;

$serverUrl = 'http://localhost:' . $chromeDriverPort;
$webdriver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

$linkDaPagina = new SteamTags();
$linkDaPagina = $linkDaPagina->linkComTag($linkDaPagina->online_coop, $valorMaximo);

$webdriver->get($linkDaPagina);

$listaBonsJogos = lerPagina($webdriver);

escreverListaTemporaria($listaBonsJogos, $nomeInstancia);
