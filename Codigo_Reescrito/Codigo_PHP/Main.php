<?php
/*
Aqui é a partida do carro.
E também quem o desliga.
*/

require_once 'Funcoes/cronometro.php';                                  // Para determinar o tempo
$cronometro = new Cronometro();
$cronometro->iniciar();



use Banco\Persistente\Controlador;
               
require_once 'Config.php';                                                  // Local dos arquivos
require_once 'Funcoes/montarListasTemporarias.php';                        // Monta as listas temporárias feitas
require_once 'Funcoes/ordenarLista.php';                                    // Ordena a lista
require_once 'Classes/Jogo.php';                    
require_once 'Funcoes/escreverPromocoes.php';                               // Escreve a lista
require_once 'Funcoes/escreverTempoDeExecucao.php';                         // Tempo de execução
require_once __DIR__ . '/../Acesso_Banco/Persistente/Controlador.php';      // Controlador do banco de dados


// // Iniciar Chromedriver
// $comandoChromeDriver = escapeshellcmd('C:/Python/SeleniumPackages/chromedriver.exe');
// shell_exec($comandoChromeDriver);
// // Iniciar Selenium
// $comandoWebdriver1 = escapeshellcmd("php $enderecoDoCodigo/ChromeWindow1.php");
// $comandoWebdriver2 = escapeshellcmd("php $enderecoDoCodigo/ChromeWindow2.php");
// shell_exec($comandoWebdriver1);
// shell_exec($comandoWebdriver2);
// require_once "$enderecoDoCodigo/ChromeWindow1.php";
// require_once "$enderecoDoCodigo/ChromeWindow2.php";

// Montar Lista
$listaDeJogos = montarListasTemporarias();
$listaOrdenada = ordenarLista($listaDeJogos);


// Para cronômetro
$cronometro->stop();
$contagemLista = count($listaOrdenada);

$dadosEstatisticos = [
    'jogosCadastrados' => $contagemLista,
    'leBundles' => 0,
    'tempoDeExecucao' => $cronometro->tempoTotalString(),
    'segundosPorJogo' => '0'
];

// Cria arquivo com promoções e tempo de execucação
escreverPromocoes(
    listaOrdenada: $listaOrdenada,
    len_listaOrdenada: $contagemLista,
    horaZero: $cronometro->chamarHoraZero(),
    tempoTotalString: $cronometro->tempoTotalString()
);

escreverTempoDeExecucao(
    count_listaOrdenada: $contagemLista,
    tempoTotal: $cronometro->tempoTotal(),
    horaZero: $cronometro->chamarHoraZero(),
    tempoTotalString: $cronometro->tempoTotalString()
);


// Inserir informações no Banco
$controlador = new Controlador();
$controlador->limparSchema();
$controlador->inserirJogos($listaOrdenada);
$controlador->inserirDadosEstatisticos($dadosEstatisticos);