<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

function findElementWithWait(RemoteWebDriver $webdriver, int $timeout_in_second, int $interval_in_milisecond, string $xpath) : RemoteWebElement
{
    $webdriver->wait($timeout_in_second, $interval_in_milisecond)->until(
        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpath))
    );

    return $webdriver->findElement(WebDriverBy::xpath($xpath));
}