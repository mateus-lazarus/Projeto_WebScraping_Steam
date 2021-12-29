<?php


function ordenarLista(array $listaNaoOrdenada) : array
{
    // Para saber mais da função :   https://www.php.net/manual/en/function.rsort.php
    //                              https://www.php.net/manual/en/function.setlocale.php

    //   modelo do dicionário :
    //   [nomeJogo, precoAntes, precoDepois, desconto, linkJogo, linkFoto, descricaoJogo] 


    setlocale(LC_CTYPE, $listaNaoOrdenada[3]);      // Para definir qual será o critério de ordem
    rsort($listaNaoOrdenada, SORT_LOCALE_STRING);

    return $listaNaoOrdenada;
}