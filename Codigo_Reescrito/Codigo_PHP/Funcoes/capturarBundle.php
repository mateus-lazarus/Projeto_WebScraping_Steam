<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

require_once 'chutarInteiro.php';
require_once 'esperar.php';
require_once __DIR__ . '/Webdriver/findElementWithWait.php';


function capturarBundle(string $jogoLink, RemoteWebDriver $webdriver) : array
{
    // Para facilitar o acesso
    $wb = $webdriver;

    // devido ao erro, não mais rodo bundles
    return [];

    $wb->executeScript('window.open()');
    $wb->switchTo()->window($wb->getWindowHandles()[1]);
    $wb->get($jogoLink);

    while (str_contains($wb->getCurrentURL(), 'agecheck') ) {
        echo 'RONDANDO O FREAKING WHILE' . PHP_EOL;
        // Tentativa de Correção : 1
        // Criei uma nova função "findElementWithWait"
        findElementWithWait($wb, 5, 250, '//*[@id="ageYear"]')->click();
        $chutarInteiro = chutarInteiro(0, 5);
        findElementWithWait($wb, 5, 250, "//*[@id='ageYear']/option[$chutarInteiro]")->click();

        findElementWithWait($wb, 5, 250, '//*[@id="ageDay"]')->click();
        $chutarInteiro = chutarInteiro(0, 12);
        findElementWithWait($wb, 5, 250, "//*[@id='ageDay']/option[$chutarInteiro]")->click();
        
        findElementWithWait($wb, 5, 250, '//*[@id="ageMonth"]')->click();
        $chutarInteiro = chutarInteiro(0, 3);
        findElementWithWait($wb, 5, 250, "//*[@id='ageMonth']/option[$chutarInteiro]")->click();
        
        findElementWithWait($wb, 5, 250, '//*[@class="agegate_text_container btns"]/a[1]')->click();
    }

    // O CÓDIGO NUNCA PASSA DAQUI.

    try {
        try {
            // Espera para encontrar a foto do jogo, a melhor base para saber se é um BUNDLE ou um JOGO
            $wb->wait(6, 500)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//*[@id="gameHeaderImageCtn"]/img'))
            );

            $jogoDescricao = $wb->findElement(WebDriverBy::xpath('//*[@id="game_highlights"]/div[1]/div/div[2]'))->getText();
        }

        catch (Exception) {
            $jogoDescricao = $wb->findElement(WebDriverBy::xpath('//*[@id="game_highlights"]/div[1]/div/div[2]'))->getText();
        }
    }

    catch (Exception) {
        // Não é considero um ERRO MENOR, porque alguns bundles simplesmente não possuem descrição
        $jogoDescricao = 'Essa promoção é um BUNDLE, sugiro que entre para ver os jogos um a um';
    }


    try {
        $linkFoto = findElementWithWait($wb, 10, 250, '//*[@id="gameHeaderImageCtn"]/img')->getAttribute('src');
        $linkVideo = $wb->findElement(WebDriverBy::xpath('//*[@class="highlight_player_item highlight_movie"]'))->getAttribute('data-webm-hd-source');

    }

    catch (Exception) {
        // Não é considero um ERRO MENOR, pois nem todos jogos possuem algum vídeo
        try {
            $linkFoto = findElementWithWait($wb, 10, 250, '//*[@id="gameHeaderImageCtn"]/img')->getAttribute('src');
            $linkVideo = 0;
        }
        
        catch (Exception) {
            $linkFoto = findElementWithWait($wb, 10, 250, '//*[@id="package_header_container"]/img')->getAttribute('src');
            $linkVideo = 0;
        }
    }

    $janelaInicial = $wb->getWindowHandles()[0];
    $wb->executeScript('window.close()');
    $wb->switchTo()->window($janelaInicial);


    return [$linkVideo, $linkFoto, $jogoDescricao];
}