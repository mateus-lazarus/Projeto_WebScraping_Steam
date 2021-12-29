<?php

use WpOrg\Requests\Requests;

function carregarPagina(string $jogoID)
{
    // Faz um request e carrega em json as informações do site
    // Uso o link da api, pois ela devolve as informações sem dor de cabeça para o JSON
    
    $formatoLink = "http://store.steampowered.com/api/appdetails?appids=$jogoID";

    try {
        for ($i = 0; $i < 3; $i++) {
            $pagina = Requests::get($formatoLink);
            $status = $pagina->status_code;
            if ($status == 200) {
                break;
            };
        }
    
        $content = $pagina->body;
        $content = json_decode($content);

        return $content;
    }

    catch (Exception $e) {
        echo "CARREGAR PÁGINA. STATUS CODE : $status" . PHP_EOL;
        echo $e->getMessage();
        return;
    }    
}






















