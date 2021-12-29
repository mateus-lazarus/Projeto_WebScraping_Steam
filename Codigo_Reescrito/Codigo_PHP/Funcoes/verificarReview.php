<?php

/*
    Uma dor de cabeça ferrada. O PHP NÃO aceita variáveis globais dentro de uma função, um encapsulamento total. Para acessar variáveis
        externas há dois meios : global $variable ou colocar a variável dentro da função.

    Irei pedir a variável na função, pois sei que o arquivo que a chamar irá ter de fazer o mesmo require

        Para caso queira reler : https://stackoverflow.com/questions/2531221/giving-my-function-access-to-outside-variable
*/


# require 'Codigo_Reescrito\Codigo_PHP\Config.php';



function verificarReview(string $review, string $criterioEmVigor, array $criteriosDeReview) : bool
{ 
    # Esse código funcionará diferentemente de Python pois a linguagem permite outra abordagem
    $reviewMinimo = array_search($criterioEmVigor, $criteriosDeReview);

    if(array_search($review, $criteriosDeReview) > $reviewMinimo) {
        return true;
    };

    return false;
}



























