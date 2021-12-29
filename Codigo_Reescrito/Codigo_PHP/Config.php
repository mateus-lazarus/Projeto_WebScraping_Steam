<?php

// Arquivo para definições do código que irá rodar, assim não será necessário mexer em nada do "hard-code" para alterações
//   de comportamento básicas


$descontoMinimo = 80;   
$valorMaximo = 20;      // dos jogos, já considerando desconto
$criteriosDeReview = array(
    // Em ordem da melhor para a pior. Fará sentido o uso de ARRAY à frente
    'Extremamente positivas',
    'Muito positivas',
    'Ligeiramente positivas',
    'Neutras'
);

$criterioEmVigor = $criteriosDeReview[2];


$enderecoDaPasta = 'C:\Users\Pichau\Documents\Blocos de Anotações do OneNote\SiteSteam';
$enderecoDoCodigo = 'C:\Users\Pichau\Desktop\Python\Area_de_Testes\Programas\Reescrevendo_Código\Projeto_WebScraping_Steam\Codigo_Reescrito\Codigo_Python';
$chromeDriver = 'C:\Python\SeleniumPackages\chromedriver.exe';

// Caracteres máximos para a descrição do jogo
$caracteresMaximos = 300;




class SteamTags 
{
    public int $multiplayer = 3859;
    public int $action = 19;
    public int $online_coop = 3843;
    public int $coop = 1685;
    public int $strategy = 9;
    public int $software = 8013;
    
    public function linkComTag($tag1, $valorMaximo, $tag2 = null, $tag3 = null) : string
    {
        if ($tag3 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1%2C$tag2%2C$tag3&specials=1";
        }

        elseif ($tag2 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1%2C$tag2&specials=1";
        }
            
        elseif ($tag1 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1&specials=1";
        }
            
        else {
            var_dump(debug_backtrace());
        }

        return $steamLink;
    }
}

// Nome das instâncias que serão abertas para utilizar do multiprocessamento
$instanciaUm = 'Webdriver_1';
$instanciaDois = 'Webdriver_2';

