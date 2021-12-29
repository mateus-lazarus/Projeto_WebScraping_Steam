<?php

# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código


require 'C:/Users/Pichau/Desktop/Python/Area_de_Testes/Programas/Reescrevendo_Código\Projeto_WebScraping_Steam/Codigo_Reescrito/Codigo_PHP/Dependencias/vendor/autoload.php';
use Aeon\Calendar\Gregorian\GregorianCalendar;

/*
Deixei aqui para facilitar o entendimento do processo

    $dateTime = GregorianCalendar::UTC()->now();
    $dateTime = $dateTime->day();
    $dateTime = $dateTime->format('d-m-Y');
*/

function data() : string
{
    $data = GregorianCalendar::UTC()->now()->day()->format('d-m-Y');
    return $data;
}




