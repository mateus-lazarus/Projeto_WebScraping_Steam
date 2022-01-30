<?php


function ordenarLista(array $listaNaoOrdenada) : array
{
    // Para saber mais da função :   https://www.php.net/manual/en/function.rsort.php
    //                               https://www.php.net/manual/en/function.setlocale.php
    //                               https://stackoverflow.com/questions/1597736/how-to-sort-an-array-of-associative-arrays-by-value-of-a-given-key-in-php
    //                               https://www.php.net/manual/en/function.usort.php -- Esse é o que funcionou
    

    //   modelo do dicionário :
    //   [nomeJogo, precoAntes, precoDepois, desconto, linkJogo, linkFoto, descricaoJogo] 


    usort(                                          // https://www.php.net/manual/en/function.usort.php
        $listaNaoOrdenada,
        function ($a, $b) {                         // $a é o item de comparação 1, $b é item de comparação 2
            if ($a->precoDepois > $b->precoDepois) {return -1;}
            if ($a->precoDepois < $b->precoDepois) {return 1;}
            if ($a->precoDepois == $b->precoDepois) {return 0;}
            exit();
        }
    );


    // Caso queira verificar a ordem do item[2] de cada jogo
    // foreach ($listaNaoOrdenada as $key1 => $value1) {
    //     var_dump($listaNaoOrdenada[$key1][2]);
    // }



    return $listaNaoOrdenada;
}