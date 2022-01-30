<?php

namespace Banco\Instancias;

use ErrorException;
use PDO;
use PDOStatement;

trait InserirBanco
{
    public function inserirBanco(array $informacoesJogo) : void
    {   
        // Assim tenho segurança de que só será passada as informações para o banco caso todas funcionem.

        $sqlQuery = "INSERT INTO {$this->schemaNome}.{$this->tableNome}
        VALUES (
            null,
            :nome,
            :precoAntes,
            :precoDepois,
            :desconto,
            :linkJogo,
            :linkVideo,
            :linkFoto,
            :descricao,
            NOW(),
            NOW()
        );";

        /** @var PDOStatement @preparedStatement */
        $preparedStatement = $this->conexao->prepare($sqlQuery);


        foreach ($informacoesJogo as $jogo) {
            $this->conexao->beginTransaction();
            $preparedStatement->bindParam(':nome', $jogo->nomeJogo, PDO::PARAM_STR);
            $preparedStatement->bindParam(':precoAntes', $jogo->precoAntes, PDO::PARAM_STR);
            $preparedStatement->bindParam(':precoDepois', $jogo->precoDepois, PDO::PARAM_STR);
            $preparedStatement->bindParam(':desconto', $jogo->desconto, PDO::PARAM_STR);
            $preparedStatement->bindParam(':linkJogo', $jogo->linkJogo, PDO::PARAM_STR);
            $preparedStatement->bindParam(':linkVideo', $jogo->linkVideo, PDO::PARAM_STR);
            $preparedStatement->bindParam(':linkFoto', $jogo->linkFoto, PDO::PARAM_STR);
            $preparedStatement->bindParam(':descricao', $jogo->descricaoJogo, PDO::PARAM_STR);

            $preparedStatement->execute();

            if ($this->conexao->commit() ) {
                
            } else {
                throw new ErrorException("Houve um problema ao enviar as informações ao banco.\n\nNome do jogo : {$jogo[0]}");
            }
        }
        
        
        echo 'Sucesso ao enviar informações no banco' . PHP_EOL;

    }
    
}
