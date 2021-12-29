<?php

require 'Codigo_Reescrito\Codigo_PHP\Config.php';

function capturarPagina(string $linkJogo, string $jogoID, int &$ERRO_MENOR) : array
{
    global $caracteresMaximos;

    $pagina = carregarPagina($jogoID);

    if ($pagina[$jogoID]['success'] == true) {
        $descricaoJogo = $pagina[$jogoID]['data']['short_description'];

        if (count($descricaoJogo) >= $caracteresMaximos) {
            // assim que atingir a quantidade máxima de caracteres o texto será cortado no primeiro espaço (" ")
            # linha 96
            # linha 97
        }

        $linkFoto = $pagina[$jogoID]['data']['header_image'];

        try {
            $linkVideo = $pagina[$jogoID]['data']['movies'][0]['mp4']['max'];
        }
        catch (Exception) {
            $linkVideo = 0;
        }
    }

    else {
        $ERRO_MENOR += 1;
        echo 'Erro. CAPTURAR PÁGINA.' . PHP_EOL;
        echo "Link do jogo : $linkJogo" . PHP_EOL;
    }


    return [$linkVideo, $linkFoto, $descricaoJogo];
}








