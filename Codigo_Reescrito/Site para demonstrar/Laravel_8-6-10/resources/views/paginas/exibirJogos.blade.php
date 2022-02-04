<!-- Buscando layout da página -->
@extends('layouts.paginaDeJogos')


<!-- Informações a serem enviadas para a página -->

<!-- Titulo da pagina (o tipo de ordem de listagem sendo usado) -->
@section('tituloPagina')
Ordem Crescente - Jogos
@endsection


<!-- Lista de jogos em ordem crescente -->
@section('conteudo')

    <!-- Exibição dos jogos -->
    <section>

    <div class="container">
        <!-- Grade dos Jogos -->
        <div name="Lista-de-Jogos" class="row m-3 justify-content-around">

            <!-- O próprio código carrega todos os jogos que foram listados no Banco -->
            @include('layouts.cardJogo')

        </div>
    </div>

    </section>
@endsection