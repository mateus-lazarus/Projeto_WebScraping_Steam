<?php

namespace Banco\Instancias;

use ErrorException;
use PDO;
use PDOStatement;

trait inserirDadosEstatisticos
{
    public function inserirDadosEstatisticos(array $dadosEstatisticos) : void
    {   
        // Assim tenho segurança de que só será passada as informações para o banco caso todas funcionem.

        $sqlQuery = "INSERT INTO {$this->schemaNome}.{$this->tableDadosEstatisticos}
        VALUES (
            null,
            NOW(),
            :jogosCadastrados,
            :leBundles,
            null,
            null
        );";

        /** @var PDOStatement @preparedStatement */
        $preparedStatement = $this->conexao->prepare($sqlQuery);


        $this->conexao->beginTransaction();
        $preparedStatement->bindParam(':jogosCadastrados', $dadosEstatisticos['jogosCadastrados'], PDO::PARAM_INT);
        $preparedStatement->bindParam(':leBundles', $dadosEstatisticos['leBundles'], PDO::PARAM_INT);
        // $preparedStatement->bindParam(':tempoDeExecucao', $dadosEstatisticos['tempoDeExecucao'], PDO::PARAM_STR);
        // $preparedStatement->bindParam(':segundosPorJogo', $dadosEstatisticos['segundosPorJogo'], PDO::PARAM_STR);

        $preparedStatement->execute();

        if ($this->conexao->commit() ) {
            
        } else {
            throw new ErrorException("Houve um problema ao enviar as informações ao banco.\n");
        }
        
        
        echo 'Sucesso ao enviar informações no banco' . PHP_EOL;

    }
    
}
