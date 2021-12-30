<?php

# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código


require_once './Dependencias/vendor/autoload.php';
require_once 'formatarHora.php';

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

    public function tempoMarcacao(int $IdMarcacao) : string
    {
        $tempoDecorrido = $this->elapsedTime($IdMarcacao)->inSeconds();
        return formatarHora($tempoDecorrido);
    }

    public function tempoTotal() : string
    {
        $tempoTotal = $this->totalElapsedTime()->inSeconds();
        return formatarHora($tempoTotal);
    }

}