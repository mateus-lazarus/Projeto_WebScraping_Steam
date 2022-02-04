<?php


trait Configuracoes
{
    // Dados necessários para fazer a conexão com o Banco de Dados
    
    protected $tipo = 'mysql';
    protected $url = 'localhost';
    protected $port = '3306';
    
    protected $schemaNome = 'webscraping_steam';
    protected $tableJogos = 'jogos';
    protected $tableDadosEstatisticos = 'dadosestatisticos';
    
    protected $usuario = 'root';
    protected $senha = 'euseidetudo';
}


?>