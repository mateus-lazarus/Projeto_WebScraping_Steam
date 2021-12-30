<?php
/*
Aqui é a partida do carro.
E também quem o desliga.
*/


require_once 'Funcoes/cronometro.php';                      // Para determinar o tempo
require_once 'Config.php';                                  // Local dos arquivos
require_once 'Funcoes/montarListasTemporarias.php';        // Monta as listas temporárias feitas
require_once 'Funcoes/ordenarLista.php';                    // Ordena a lista
require_once 'Classes/Jogo.php';
require_once 'Funcoes/escreverPromocoes.php';               // Escreve a lista
require_once 'Funcoes/escreverTempoDeExecucao.php';         // Tempo de execução

$cronometro = new Cronometro();
$cronometro->start();


//exec("$enderecoDoCodigo/ChromeWindow1.php");
//exec("$enderecoDoCodigo/ChromeWindow2.php");


$listaDeJogos = montarListasTemporarias();
$listaOrdenada = ordenarLista($listaDeJogos);
escreverPromocoes($listaOrdenada, Jogo::devolverContador());

escreverTempoDeExecucao(Jogo::devolverContador(), $cronometro->chamarHoraZero(), $cronometro->tempoTotal());