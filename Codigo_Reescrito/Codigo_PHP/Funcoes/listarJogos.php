<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\NoSuchElementException;
use JetBrains\PhpStorm\ExpectedValues;

require_once '.\Config.php';
require_once 'verificarReview.php';
require_once 'lerDesconto.php';
require_once 'capturarInformacoesAdicionais.php';
require_once 'formatarNumero.php';
require_once '.\Classes\Jogo.php';

function listarJogos(int $numeroJogosLidos, int $descontoMinimo, string $Xpath, RemoteWebDriver $webdriver) : array
{
    global $criterioEmVigor;
    global $criteriosDeReview;

    $XP = $Xpath;
    $wb = $webdriver;

    // Definir variáveis de erros
    $ERRO_MAIOR = 0;
    $ERRO_MENOR = 0;

    $numeroJogosBons = 0;

    $listaJogosBons = [];


    for ($contagem_de_rodadas = 1; $contagem_de_rodadas <= $numeroJogosLidos + 1; $contagem_de_rodadas++) {
        $x = $contagem_de_rodadas;
        echo "Contagem de rodadas : $x" . PHP_EOL;
        
        try {
            // Para casos de jogos sem o ícone de avaliação
            try {
                $reviewLido = $wb->findElement(WebDriverBy::xpath("$XP/a[$x]/div[2]/div[3]/span"));
                $reviewLido = $reviewLido->getAttribute('data-tooltip-html');
                $reviewLido = substr($reviewLido, 0, strpos($reviewLido, '<br>'));
                // Para saber mais do que foi feito : https://www.php.net/manual/en/function.substr
                echo "Review sendo lido : $reviewLido" . PHP_EOL;
            }

            catch (Exception $e) {
                echo 'Error. REVIEW LIDO.' . PHP_EOL . $e->getMessage() . PHP_EOL;
                continue;
            }


            if (verificarReview($reviewLido, $criterioEmVigor, $criteriosDeReview)) {
                echo "Verificando review mesmo..." . PHP_EOL;
                // Para quando o desconto retornar vazio (algo impossível, pois eu já coloquei o critério de apenas mostrar jogos com desconto)
                $descontoLido = lerDesconto($XP, $x, $webdriver);
                if ($descontoLido == false) {
                    continue;
                }

                if ($descontoLido >= $descontoMinimo) {
                    $nomeJogoLido = $wb->findElement(WebDriverBy::xpath("$Xpath/a[$x]/div[2]/div[1]/span"))->getText();
                    $linkJogo = $wb->findElement(WebDriverBy::xpath("$Xpath/a[$x]"))->getAttribute('href');

                    try {
                        [$linkVideo, $linkFoto, $descricaoJogo] = capturarInformacoesAdicionais($linkJogo, $x, $ERRO_MENOR, $webdriver);
                        if ($linkFoto == null) {
                            throw new Exception();
                        }
                    }

                    catch (Exception $e) {
                        $linkVideo = '';
                        $linkFoto = '';
                        $descricaoJogo = '';

                        $ERRO_MENOR += 1;
                        echo $e->getMessage() . PHP_EOL;
                        echo PHP_EOL . PHP_EOL . "Nome do jogo : $nomeJogoLido" . PHP_EOL;
                        echo "Erro menor ocorrido. INFORMAÇÕES ADJACENTES. {$x}º voltas." . PHP_EOL . PHP_EOL;
                        continue;
                    }


                    try {
                        $valoresDoJogo = $wb->findElement(WebDriverBy::xpath("$XP/a[$x]/div[2]/div[4]/div[2]"))->getText();
                        $precoAntes = substr($valoresDoJogo, 0, strpos($valoresDoJogo, "\n"));
                        $precoAntes = formatarNumero($precoAntes, 2, 2);

                        $precoDepois = substr($valoresDoJogo, strpos($valoresDoJogo, "\n") + 1);
                        $precoDepois = formatarNumero($precoDepois, 2, 2);

                        // Calcular desconto
                        $descontoCalculado = 1 - ($precoDepois / $precoAntes);
                        $descontoCalculado = formatarNumero($descontoCalculado * 100, 2, 2, porcentagem:true);
                    }

                    catch (Exception $e) {
                        echo $e->getMessage() . PHP_EOL;

                        $precoAntes = 'Não há promoção aqui.';
                        $precoDepois = $wb->findElement(WebDriverBy::xpath("//*[@id='search_resultsRows']/a[$x]/div[2]/div[4]/div[2]"))->getText();
                        $descontoCalculado = '0%';

                        $ERRO_MENOR += 1;
                        echo $e->getMessage() . PHP_EOL;
                        echo PHP_EOL . PHP_EOL . "Nome do jogo : $nomeJogoLido" . PHP_EOL;
                        echo "Erro menor ocorrido. DESCONTO REAL. {$x}º voltas." . PHP_EOL . PHP_EOL;
                        continue;
                    }

                    if ($linkVideo == 0 || $linkVideo == '') {
                        if ($linkFoto == '') {
                            $objetoTemporario = new Jogo($nomeJogoLido, $precoAntes, $precoDepois, $linkJogo);
                        }

                        $objetoTemporario = new Jogo($nomeJogoLido, $precoAntes, $precoDepois, $linkJogo, link_foto:$linkFoto, descricao_jogo:$descricaoJogo);
                    }

                    else {
                        $objetoTemporario = new Jogo($nomeJogoLido, $precoAntes, $precoDepois, $linkJogo, $linkVideo, $linkFoto, $descricaoJogo);
                    }
                    
                    array_push($listaJogosBons, $objetoTemporario->devolverInfo());
                    unset($objetoTemporario);
                }
            }
        }



        catch (Exception $e) {
            $ERRO_MAIOR += 1;
            echo "\n\n\n\n\nContagem de GRANDES ERROS : $ERRO_MAIOR." . PHP_EOL;
            echo "Ocorrido na {$contagem_de_rodadas}º volta." . PHP_EOL;
            echo PHP_EOL . $e->getMessage();
            echo "\n\n\n\n";

            esperar(900);
            continue;
        }
        
    }


    echo "Contagem de PEQUENOS ERROS : $ERRO_MENOR" . PHP_EOL;
    echo "\n Listagem de Jogos finalizada.";
    $wb->quit();

    return $listaJogosBons;
}