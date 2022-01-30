<?php


class Jogo
{
    private string $nomeJogo;
    private float | string $precoAntes;
    private float | string $precoDepois;
    private string $linkJogo;
    private string | null $linkVideo;
    private string | null $linkFoto;
    private string $descricaoJogo;


    public function __construct(string $nome_jogo, float $preco_antes, float $preco_depois, string $link_jogo, string | null $link_video = null, string | null $link_foto = null, string $descricao_jogo = '')
    {
        $this->nomeJogo = $nome_jogo;
        $this->precoAntes = $preco_antes;
        $this->precoDepois = $preco_depois;
        $this->linkJogo = $link_jogo;
        $this->linkVideo = $link_video;
        $this->linkFoto = $link_foto;
        $this->descricaoJogo = $descricao_jogo;
    }

    public function devolverInfo() : array
    {
        # Eu gosto de calcular o desconto, pois assim sei REALMENTE quanto de desconto aquele jogo tem
        $divisao = $this->precoDepois / $this->precoAntes;

        if ($divisao > 0) {
            $desconto = (1 - $divisao) * 100;
            $desconto = formatarNumero($desconto, 2, 1, porcentagem: false);
        }
        else {
            $desconto = 'Erro.';
        }


        $this->precoAntes = formatarNumero($this->precoAntes, 2, 2, simboloMoeda: false);
        $this->precoDepois = formatarNumero($this->precoDepois, 2, 2, simboloMoeda: false);


        $informacoes = [
            'nomeJogo' => $this->nomeJogo,
            'precoAntes' => $this->precoAntes,
            'precoDepois' => $this->precoDepois,
            'desconto' => $desconto,
            'linkJogo' => $this->linkJogo,
            'linkVideo' => $this->linkVideo,
            'linkFoto' => $this->linkFoto,
            'descricaoJogo' => $this->descricaoJogo
        ];

        return $informacoes;
    }
}