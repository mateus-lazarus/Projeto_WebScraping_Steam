<?php

# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código


require_once __DIR__ . '/../Dependencias/vendor/autoload.php';
require_once 'formatarHora.php';
require_once 'hora.php';

use Aeon\Calendar\Stopwatch;

# https://aeon-php.org/docs/calendar/1.x/stopwatch/
# documentação da função

/*
Alterei a classe Stopwatch para permitir que eu consiga criar classes filhas de Stopwatch
*/


class Cronometro extends Stopwatch
{
    private string $horaZero;

    public function iniciar() : void
    {
        $this->horaZero = hora();
        $this->start();
    }

    public function parar() : void
    {
        $this->stop();
    }

    public function chamarHoraZero() : string
    {
        return $this->horaZero;
    }

    public function criarMarcacao() : void
    {
        $this->lap();
    }

    public function quantasMarcacoes() : int
    {
        return $this->laps();
    }

    public function tempoMarcacao(int $IdMarcacao) : int
    {
        $tempoDecorrido = $this->elapsedTime($IdMarcacao)->inSeconds();
        return $tempoDecorrido;
    }

    public function tempoMarcacaoString(int $IdMarcacao) : int
    {
        $tempoDecorrido = $this->elapsedTime($IdMarcacao)->inSeconds();
        return formatarHora($tempoDecorrido);
    }

    public function tempoTotal() : int
    {
        $tempoTotal = $this->totalElapsedTime()->inSeconds();
        return $tempoTotal;
    }

    public function tempoTotalString() : string
    {
        $tempoTotal = $this->totalElapsedTime()->inSeconds();
        return formatarHora($tempoTotal);
    }

}