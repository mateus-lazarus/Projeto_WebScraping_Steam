<?php

# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código

# Fonte para códigos de formatação : https://www.php.net/manual/en/datetime.format.php


require_once './Dependencias/vendor/autoload.php';
use Aeon\Calendar\Gregorian\GregorianCalendar;
use Aeon\Calendar\Gregorian\TimeZone;

/*
$dateTime = new GregorianCalendar(TimeZone::americaSaoPaulo());
$dateTime = $dateTime->now()->time();

# Fonte para códigos de formatação : https://www.php.net/manual/en/datetime.format.php
$dateTime = $dateTime->format('G:i:s');
*/

function hora() : string
{
    $dateTime = new GregorianCalendar(TimeZone::americaSaoPaulo());
    return $dateTime->now()->time()->format('G:i:s');
}