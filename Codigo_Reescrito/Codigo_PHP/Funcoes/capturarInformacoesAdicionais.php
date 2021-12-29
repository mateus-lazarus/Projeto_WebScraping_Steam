<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

function capturarInformacoesAdicionais(string $linkJogo, int $contagem_de_rodadas, int &$ERRO_MENOR, RemoteWebDriver $webdriver) : array
{
    if (str_contains($linkJogo, 'app')) {
        $jogoID = $webdriver->findElement(WebDriverBy::xpath("//*[@id='search_resultsRows']/a[$contagem_de_rodadas]/."))->getAttribute('data-ds-appid');
        
        [$linkVideo, $linkFoto, $descricaoJogo] = capturarPagina($linkJogo, $jogoID, $ERRO_MENOR);
        
        return [$linkVideo, $linkFoto, $descricaoJogo];
    }

    else {
        [$linkVideo, $linkFoto, $descricaoJogo] = capturarBundle($linkJogo, $webdriver);
        return [$linkVideo, $linkFoto, $descricaoJogo];
    }
}



