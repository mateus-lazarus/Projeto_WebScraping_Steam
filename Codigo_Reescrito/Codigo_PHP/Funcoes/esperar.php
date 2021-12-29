<?php

# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código


function esperar(int $tempo) : void
{
    sleep($tempo);
}