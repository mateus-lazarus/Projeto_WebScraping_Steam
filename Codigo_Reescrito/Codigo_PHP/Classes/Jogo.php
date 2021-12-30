<?php


class Jogo
{
    private static int $contador = 0;

    private string $nomeJogo;
    private float | string $precoAntes;
    private float | string $precoDepois;
    private string $linkJogo;
    private string | int $linkVideo;
    private string $linkFoto;
    private string $descricaoJogo;


    public function __construct(string $nome_jogo, float $preco_antes, float $preco_depois, string $link_jogo, string | int $link_video = '', string $link_foto = '', string $descricao_jogo = '')
    {
        $this->nomeJogo = $nome_jogo;
        $this->precoAntes = $preco_antes;
        $this->precoDepois = $preco_depois;
        $this->linkJogo = $link_jogo;
        $this->linkVideo = $link_video;
        $this->linkFoto = $link_foto;
        $this->descricaoJogo = $descricao_jogo;

        self::$contador++;
    }

    public function devolverInfo() : array
    {
        # Eu gosto de calcular o desconto, pois assim sei REALMENTE quanto de desconto aquele jogo tem
        $divisao = $this->precoDepois / $this->precoAntes;

        if ($divisao > 0) {
            $desconto = (1 - $divisao) * 100;
            $desconto = formatarNumero($desconto, 2, 1, porcentagem: true);
        }
        else {
            $desconto = 'Erro.';
        }


        $this->precoAntes = formatarNumero($this->precoAntes, 2, 2, simboloMoeda: true);
        $this->precoDepois = formatarNumero($this->precoDepois, 2, 2, simboloMoeda: true);


        $informacoes = [
            $this->nomeJogo,
            $this->precoAntes,
            $this->precoDepois,
            $desconto,
            $this->linkJogo,
            $this->linkVideo,
            $this->linkFoto,
            $this->descricaoJogo
        ];

        return $informacoes;
    }

    static function devolverContador() : int
    {
        return self::$contador;
    }
}