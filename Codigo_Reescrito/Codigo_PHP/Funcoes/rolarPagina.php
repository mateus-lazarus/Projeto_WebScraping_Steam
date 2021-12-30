<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once 'esperar.php';

function rolarPagina(RemoteWebDriver $webdriver, string $xpath) : int
{
    $jogosMostrados = count($webdriver->findElements(WebDriverBy::xpath("$xpath/a")));

    # Enquanto a quantidade de jogos aumentar, continuará descendo a página
    # Vi que é bom definir um limite de rolagem, pois a steam já está configurada para mostrar por ordem de relevância
    $rolagem = 2;

    while (true)
    {
        $webdriver->executeScript('window.scrollTo(0,document.body.scrollHeight)');
        esperar(2);

        $novaContagem = count($webdriver->findElements(WebDriverBy::xpath("$xpath/a")));
        
        if ($rolagem > 2) {
            return $jogosMostrados;
        }

        if ($novaContagem > $jogosMostrados) {
            $jogosMostrados = $novaContagem;
            $rolagem += 1;
            continue;
        }

    }
}