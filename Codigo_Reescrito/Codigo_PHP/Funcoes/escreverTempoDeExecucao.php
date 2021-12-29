<?php

// Para mais informações : https://www.w3schools.com/php/php_file_create.asp

require 'Codigo_Reescrito\Codigo_PHP\Config.php';

function escreverTempoDeExecucao(int $count_listaOrdenada, string $horaZero, string $tempoTotal)
{
    global $enderecoDaPasta;
    
    $arquivoExecucaoUm = fopen("$enderecoDaPasta\Tempo_de_execucao.txt", 'w');
    fwrite($arquivoExecucaoUm, "⭐ $horaZero\n");
    fwrite($arquivoExecucaoUm, "\nTempo de Execução : $tempoTotal");
    fclose($arquivoExecucaoUm);


    $arquivoExecucaoDois = fopen("$enderecoDaPasta\Tempo_de_execucao.txt", 'a');
    $frase1 = "\n\t$tempoTotal\t->->\t $count_listaOrdenada games em ";
    $frase2 = data() . '. Finalizado às ' . hora() . '. ';

    $segundosPorJogo = $tempoTotal / $count_listaOrdenada;
    $frase3 = formatarNumero($segundosPorJogo, 1, 3) . 's por jogo' . PHP_EOL;

    $fraseToda = $frase1 . $frase2 . $frase3;
    fwrite($arquivoExecucaoDois, $fraseToda);
    fclose($arquivoExecucaoDois);
}