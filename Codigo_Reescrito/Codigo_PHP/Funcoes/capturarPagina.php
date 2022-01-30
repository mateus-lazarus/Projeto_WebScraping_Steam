<?php

require_once '.\Config.php';
require_once 'carregarPagina.php';


function capturarPagina(string $linkJogo, string $jogoID, int &$ERRO_MENOR) : array
{
    global $caracteresMaximos;

    $pagina = carregarPagina($jogoID);


    $variavelUm = @$pagina->{$jogoID}->{'success'};
    $variavelDois = @$pagina->{$jogoID}->{'data'};
    if (is_null($variavelUm) === true && is_null($variavelDois) === true ) {
        return [null, null, null];
    }

    elseif ($pagina->{$jogoID}->{'success'} == true) {
        $descricaoJogo = $pagina->{$jogoID}->{'data'}->{'short_description'};

        if (strlen($descricaoJogo) >= $caracteresMaximos) {
            // assim que atingir a quantidade máxima de caracteres o texto será cortado no primeiro espaço (" ")
            $posicaoACortar = strpos(strtolower($descricaoJogo), ' ', 280);                 // https://www.w3schools.com/php/func_string_stripos.asp
            if ($posicaoACortar === false) {
                $descricaoJogo = '';
            } else {
                $descricaoJogo = str_split($descricaoJogo, $posicaoACortar)[0];             // https://www.w3schools.com/php/func_string_str_split.asp
                $descricaoJogo .= ' ...';
            }
        }


        if (@!is_null($pagina->{$jogoID}->{'data'}->{'header_image'}) ) {
            $linkFoto = $pagina->{$jogoID}->{'data'}->{'header_image'};
        } else {
            $linkFoto = null;
        }


        if (@!is_null($pagina->{$jogoID}->{'data'}->{'movies'}) ) {
            $linkVideo = $pagina->{$jogoID}->{'data'}->{'movies'}[0]->{'mp4'}->{'max'};
        } else {
            $linkVideo = null;
        }
    }

    else {
        $ERRO_MENOR += 1;
        echo 'Erro. CAPTURAR PÁGINA.' . PHP_EOL;
        echo "Link do jogo : $linkJogo" . PHP_EOL;
    }


    return [$linkVideo, $linkFoto, $descricaoJogo];
}
