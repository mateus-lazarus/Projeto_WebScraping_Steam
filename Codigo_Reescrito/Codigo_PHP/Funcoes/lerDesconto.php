<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

function lerDesconto(string $xpath, int $x, RemoteWebDriver $webdriver)
{
    try{
        $descontoLido = $webdriver->findElement(WebDriverBy::xpath("$xpath/a[$x]//*[@class='col search_price_discount_combined responsive_secondrow']/div[1]/span"))->getText();
        $descontoLido = str_replace('-','', $descontoLido);
        $descontoLido = str_replace('%','', $descontoLido);
        return intval($descontoLido);
    }

    catch (Exception $e)
    {
        echo $e->getMessage();
        return false;
    }
}