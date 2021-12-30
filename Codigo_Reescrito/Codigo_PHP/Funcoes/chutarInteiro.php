<?php


function chutarInteiro(int $inicio, int $limite) : int
{
    # inicio <= x <= limite
    # limite está incluso!

    return rand($inicio, $limite);
}