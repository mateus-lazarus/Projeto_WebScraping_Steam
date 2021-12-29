<?php

/*
    Bibliotecas para pegar as informações da web e processá-las.
    Todas necessárias.
    
*/


require './Dependencias/vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

$serverUrl = 'http://localhost:4444';

$driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());

$driver->get('https://packagist.org/');






