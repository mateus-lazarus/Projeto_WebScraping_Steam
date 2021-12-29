<?php

function formatarHora(int $seconds) : string
{
    $palhacoDateTime = new DateTime();
    $palhacoDateTime->setTime(0, 0, $seconds);
    return $palhacoDateTime->format('G:i:s');
}