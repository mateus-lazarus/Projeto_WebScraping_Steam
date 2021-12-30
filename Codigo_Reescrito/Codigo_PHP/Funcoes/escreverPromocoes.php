<?php

    //   modelo do dicionário :
    //   [nomeJogo, precoAntes, precoDepois, desconto, linkJogo, linkFoto, descricaoJogo]

require_once '.\Config.php';
require_once 'data.php';

function escreverPromocoes(array $listaOrdenada, int $len_listaOrdenada, bool $debugger = true) : void
{
    global $enderecoDaPasta;
    
    $nomeDoArquivo = 'Promocoes_da_Steam';

    $arquivo = fopen("$enderecoDaPasta\\$nomeDoArquivo.txt", 'w');
    fwrite($arquivo, "\t\t\t\t\tPromoções de " . data() . "\n");
    fwrite($arquivo, "\nJogos bons em promoção : " . $len_listaOrdenada ."\n*");
    fwrite($arquivo, "\n\n\n\n");
    fwrite($arquivo, "\t***\tJOGOS BONS EM PROMOÇÃOO\t***");
    fwrite($arquivo, "\n\n");

    foreach ($listaOrdenada as $value) {
        $tempNome = $value[0];
        $tempPrecoAntes = $value[1];
        $tempPrecoDepois = $value[2];
        $tempDesconto = $value[3];

        fwrite($arquivo, "$tempNome\t\n\t$tempPrecoAntes\t-->\t$tempPrecoDepois || $tempDesconto\n");
    }

    fclose($arquivo);



    if ($debugger) {
        $debugger = fopen("$enderecoDaPasta\\Debugger.txt", 'w');
        fwrite($debugger, "Contagem de entradas : $len_listaOrdenada");
        fwrite($debugger, "\n\n\n\n");

        foreach ($listaOrdenada as $value) {
            fwrite($arquivo, json_encode($value));
        }

        fclose($debugger);
    }
}