<?php

/*
    Uma dor de cabeça ferrada. O PHP NÃO aceita variáveis globais dentro de uma função, um encapsulamento total. Para acessar variáveis
        externas há dois meios : global $variable ou colocar a variável dentro da função.

    Irei pedir a variável na função, pois sei que o arquivo que a chamar irá ter de fazer o mesmo require

        Para caso queira reler : https://stackoverflow.com/questions/2531221/giving-my-function-access-to-outside-variable
*/


// require '..\Config.php';


function verificarReview(string $review, string $criterioEmVigor, array $criteriosDeReview) : bool
{ 
    // Esse código funcionará diferentemente de Python pois a linguagem permite outra abordagem
    $reviewMinimo = array_search($criterioEmVigor, $criteriosDeReview);

    $reviewIndex = array_search($review, $criteriosDeReview);
    echo "\n\n\n\n array search : $review\n criterio de minimo : $reviewMinimo\n posição do review : $reviewIndex\n\n\n\n";
    if(array_search($review, $criteriosDeReview) <= $reviewMinimo) {
        return true;
    };

    return false;
}
/*
echo "ordem 0 : " . $criteriosDeReview[0] . PHP_EOL;
echo "ordem 1 : " . $criteriosDeReview[1] . PHP_EOL;
echo "ordem 2 : " . $criteriosDeReview[2] . PHP_EOL;
echo "ordem 3 : " . $criteriosDeReview[3] . PHP_EOL;
*/