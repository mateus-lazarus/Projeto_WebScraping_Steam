<?php

// Arquivo para definições do código que irá rodar, assim não será necessário mexer em nada do "hard-code" para alterações
//   de comportamento básicas

$chromeDriverPort = 9515;

$descontoMinimo = 80;   
$valorMaximo = 20;      // dos jogos, já considerando desconto
$criteriosDeReview = array(
    // Em ordem da melhor para a pior. Fará sentido o uso de ARRAY à frente
    'Extremamente positivas',
    'Muito positivas',
    'Ligeiramente positivas',
    'Neutras'
);

$criterioEmVigor = $criteriosDeReview[1];
$rolagemMaxima = 0;


$enderecoDaPasta = 'C:\Users\Pichau\Documents\Blocos de Anotações do OneNote\SiteSteam';
$enderecoDoCodigo = 'C:\Users\Pichau\Desktop\Python\Area_de_Testes\Programas\Reescrevendo_Código\Projeto_WebScraping_Steam\Codigo_Reescrito\Codigo_PHP';
$chromeDriver = 'C:\Python\SeleniumPackages\chromedriver.exe';

// Caracteres máximos para a descrição do jogo
$caracteresMaximos = 300;


// Nome das instâncias que serão abertas para utilizar do multiprocessamento
$instanciaUm = 'Webdriver_1';
$instanciaDois = 'Webdriver_2';