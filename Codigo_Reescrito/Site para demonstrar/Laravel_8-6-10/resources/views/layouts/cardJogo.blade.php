<?php

        /* O padrão em telas XL será de : XL-4 XL-3 XL-4
            por isso a necessidade do código a seguir
        */

    $contador = 0;

?>

@foreach ($listaDeJogos as $jogo)
    <?php
        $contador++;
        if ($contador === 2 || ($contador - 2) % 3 === 0) {
            $tamanhoColunaXL = 3;
        } else {
            $tamanhoColunaXL = 4;
        }
    ?>


    <!-- Cada div será denominado jogo -->
    <div name="Jogo" class="col-12 col-md-5 col-lg-4 col-xl-{{ $tamanhoColunaXL }} m-2 bg-info rounded d-flex flex-column">
        <a href="{{ $jogo->jogo_linkJogo }}" target="_blank">
            <div>
                <div class="p-1 mt-2 mb-1">

                    <div class="row row-cols-sm-1 row-cols-md-2">

                        <div class="p-2 w-100">
                            
                            <span class="titulo-jogo">
                                {{ $jogo->jogo_nome }}
                            </span>
                            
                        </div>
                        

                        <div class="w-50">
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

                        <div>
                            <span>
                                Avaliação : 
                            </span>
                        </div>
                        <div>
                            <span>
                                <!-- Cálculo da identificação visual do nivel de avaliação do jogo -->
                                <?php   
                                    $nivelAvaliacao = $jogo->jogo_nivelAvaliacao;
                                    $qtdeSetas = 4 - $nivelAvaliacao;
                                ?>

                                @for ($i = 0; $i < $qtdeSetas; $i++)
                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                @endfor
                            </span>

                        </div>

                    </div>
                </div>

                    
                    
                </div>


                <!-- Verificação se há uma fonte de mídia disponível -->
                @if(empty($jogo->linkFoto) )
                
                <div class="p-1 w-100 rounded border text-light">

                    <img class="w-100" src="{{ $jogo->jogo_linkFoto }}">

                </div>

                @endif
                

                <div class="p-2 mb-3">

                    <div class="descricao-jogo">
                        <span>
                            {{ $jogo->jogo_descricao }}
                        </span>
                    </div>

                </div>

            </div>
        </a>
    </div>
@endforeach