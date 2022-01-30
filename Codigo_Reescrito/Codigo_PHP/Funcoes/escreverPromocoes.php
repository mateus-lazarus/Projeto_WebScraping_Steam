<?php

    //   modelo do dicionário :
    //   [nomeJogo, precoAntes, precoDepois, desconto, linkJogo, linkFoto, descricaoJogo]

require_once '.\Config.php';
require_once 'data.php';

function escreverPromocoes(array $listaOrdenada, int $len_listaOrdenada, string $horaZero, string $tempoTotalString, bool $debugger = true) : void
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
        $tempNome = $value->nomeJogo;
        $tempPrecoAntes = "R$ {$value->precoAntes}";
        $tempPrecoDepois = "R$ {$value->precoDepois}";
        $tempDesconto = "{$value->desconto}%";

        fwrite($arquivo, "$tempNome\t\n\t$tempPrecoAntes\t-->\t$tempPrecoDepois || $tempDesconto\n");
    }

    fclose($arquivo);



    if ($debugger) {
        $debugger = fopen("$enderecoDaPasta\\Debugger.json", 'w');

        $jsonForm = [
            'Success' => 'true',
            'Hora_de_inicio' => $horaZero,
            'Tempo_de_execucao' => $tempoTotalString,
            'Entradas' => $len_listaOrdenada,
            'Debugger' => $listaOrdenada
        ];

        // foreach ($listaOrdenada as $value) {
        //     fwrite($arquivo, json_encode($value));
        // }

        fwrite($debugger, json_encode($jsonForm, JSON_PRETTY_PRINT));

        fclose($debugger);
    }
}