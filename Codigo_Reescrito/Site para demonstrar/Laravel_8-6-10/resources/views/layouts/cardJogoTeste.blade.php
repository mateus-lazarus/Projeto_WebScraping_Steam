@section('styleAdicional')



    <style>
        <?php 
            foreach ($listaDeJogos as $jogo) {
                $nomeClasse = '.capa-jogo-id-';
                $nomeClasse .= "$jogo->jogo_id";

                $informacaoClasse = "{background-image: url('$jogo->jogo_linkFoto');}";

                $finalClasse = "$nomeClasse $informacaoClasse";

                echo $finalClasse . PHP_EOL;
            }
        ?>
    </style>



@endsection



@foreach ($listaDeJogos as $jogo)



    <?php
        $jogo_desconto = explode('.', $jogo->jogo_desconto);
        $jogo_desconto = $jogo_desconto[0];



        // Tratamento do comprimento da descrição da notícia
        $jogo_descricao = $jogo->jogo_descricao;
        
        if (mb_strlen($jogo_descricao) >= 120) {
            $posicaoACortar = mb_strpos(mb_strtolower($jogo_descricao), ' ', 110);
            if ($posicaoACortar === false) {
                $jogo_descricao = 'acesse a notícia para saber mais informações.';
            } else {
                $jogo_descricao = mb_str_split($jogo_descricao, $posicaoACortar)[0];
                $jogo_descricao .= ' ...';
            }
        }
    ?>


    <!-- Cada div será denominado jogo -->
    <div name="Jogo" class="col-12 col-md-6 col-lg-4 col-xl-4"> 
        
        <div class="my-3 rounded d-flex flex-column capa-jogo capa-jogo-id-{{ $jogo->jogo_id }} select-off">
            <div id="capa-jogo-mascara" class="rounded"></div>
    
            <div id="informacoes-da-capa" class="select-off">
    
                <div class="desconto-capa">
                    <span>
                        -{{ $jogo_desconto }}%
                    </span>
                </div>
    
                <div class="avaliacao-capa">
                    <span>
                        <!-- Cálculo da identificação visual do nivel de avaliação do jogo -->
                        <?php   
                            $nivelAvaliacao = $jogo->jogo_nivelAvaliacao;
                            $qtdeSetas = 4 - 1 - $nivelAvaliacao;   // Porque eu quero que a avaliação máxima seja 3 estrelas
                        ?>
    
                        @for ($i = 0; $i < $qtdeSetas; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </span>
                </div>
    
            </div>
        
            <div id="informacoes-jogo">
                <div class="p-1 mt-2 mb-1">
    
                    <div class="row row-cols-sm-1 row-cols-md-2">
    
                        <div class="mx-2 mb-2 w-100">
                            <a href="{{ $jogo->jogo_linkJogo }}" target="_blank">
                                <span class="titulo-jogo">
                                    {{ $jogo->jogo_nome }}
                                </span>
                            </a>
                        </div>
                    
    
                        <div class="w-50" id="preco-jogo">
                            <div class="precoAnterior-jogo">
                                <span>
                                    De R$ {{ $jogo->jogo_precoAntes }}
                                </span>
                            </div>
                            <div class="precoDepois-jogo">
                                <span>
                                    Por 
                                </span>
                                <span>
                                    <strong>R$ {{ $jogo->jogo_precoDepois }}</strong>
                                </span>
                            </div>
                        </div>
    
                    <div class="w-50 row avaliacao-jogo">
    
                        <div id="avaliacao-jogo-texto">
                            <span>
                                Avaliação : 
                            </span>
                        </div>
                        <div>
                            <span>
                                <!-- Cálculo da identificação visual do nivel de avaliação do jogo -->
                                <?php   
                                    $nivelAvaliacao = $jogo->jogo_nivelAvaliacao;
                                    $qtdeSetas = 4 - 1 - $nivelAvaliacao;   // Porque eu quero que a avaliação máxima seja 3 estrelas
                                ?>
    
                                @for ($i = 0; $i < $qtdeSetas; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </span>
                        </div>
    
                    </div>
    
                </div>
    
                    
                    
                </div>
    
    
                <!-- Verificação se há uma fonte de mídia disponível -->
                @if(empty($jogo->linkFoto) )
                
                <div class="p-1 w-100 ">
    
                    <div class="p-1 rounded border text-light">
                        <img class="w-100" src="{{ $jogo->jogo_linkFoto }}">
                    </div>
    
                </div>
    
                @endif
                
    
                <div class="p-2 mb-3">
    
                    <div class="descricao-jogo">
                        <span>
                            ❛ {{ $jogo_descricao }} ❜
                        </span>
                    </div>
    
                </div>
    
            </div>
        </div>

    </div>



@endforeach