<?php


/*
    SPRINTF trablha de maneira parecida com o FORMAT de Python.
    Para saber mais : https://www.php.net/sprintf

    STR_PAD é outra boa função de formatação.
*/


function formatarNumero(float | string $numero, int $casasFrente, int $casasTras, int $simboloMoeda = 0, int $porcentagem = 0) : string
{
    if (is_string($numero)) {
        $numero = str_replace(['R$', ' ', ','], ['', '', '.'], $numero);
    }


    $formatarDecimal = "%0" . "$casasFrente" . "d";
    $objetoDecimal = sprintf($formatarDecimal, $numero);

    $formatarFloat = "%" . ".$casasTras" . "f";
    $objetoFloat = sprintf($formatarFloat, $numero);
    $objetoFloat = explode(".", $objetoFloat);

    if ($simboloMoeda) {
        return 'R$ ' . $objetoDecimal . '.' . $objetoFloat[1];
    }

    elseif ($porcentagem) {
        # o cálculo da porcentagem já deve estar feito, aqui apenas ocorre a formatação
        return $objetoDecimal . '.' . $objetoFloat[1] . '%';
    }

    
    return $objetoDecimal . '.' . $objetoFloat[1];
}