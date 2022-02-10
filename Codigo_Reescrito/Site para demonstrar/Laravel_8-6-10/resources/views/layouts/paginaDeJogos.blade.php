<!DOCTYPE html>
<html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>@yield('tituloPagina')</title>

        <!-- Dependências -->
        <link rel='stylesheet' type='text/css' href='css\reset.css'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
        <script src="https://kit.fontawesome.com/af5cc2ff3a.js" crossorigin="anonymous"></script>
        
        <!-- Arquivos de estilo -->
        <link rel='stylesheet' type='text/css' href='css\backgrounds.css'>
        <link rel='stylesheet' type='text/css' href='css\header.css'>
        <link rel='stylesheet' type='text/css' href='css\main.css'>
        <link rel='stylesheet' type='text/css' href='css\cardJogos.css'>

        @yield('styleAdicional')
    </head>



    <body>

        <!-- Menu de Navegação estático -->
        <nav class="cabecalho">
            <div class="container-fluid">


                <div class="row justify-content-between">
                    <div class="col-12 col-sm-5 col-md-3 col-lg-3 col-xl-3 m-sm-1 m-md-2 m-lg-1 m-xl-2">

                        <!-- Github - Autor -->
                        <div class="cabecalho-identificador">
                            <a href="https://github.com/swarmfireone/swarmfireone">
                                <h3>Mateus Lazarus<br>Back-end Developer</h3>
                            </a>
                        </div>

                    </div>

                    <div class="m-3 m-sm-1 m-md-2 m-xl-3 col-12 col-sm-6 col-md-8 col-lg-8 col-xl-8">
                        <div>
                            <div class="container cabecalho-menu">

                                <!-- Formas de exibição de dados -->
                                <nav class="row">

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <a class="cabecalho-menu-item" id="Ordem-crescente" href="#">Ordem Crescente</a>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-5">
                                        <a class="cabecalho-menu-item" id="Ordem-decrescente" href="#">Ordem Decrescente</a>
                                    </div>

                                    <!-- Github -->
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                        <a class="cabecalho-menu-item" id="Github-link" href="https://github.com/swarmfireone/swarmfireone">Sobre Mim</a>
                                    </div>

                                </nav>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </nav>
    


        <main>

            <!-- Informações da última pesquisa feita -->
            <section id="informacoes-do-script">
                <br>
                <br>
                <div class="container-fluid m-2">

                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-6">
                            <!-- Estatísticas da pesquisa -->
                            <div class="informacoes-do-script"> 

                                <p class="informacoes-dia p-2">Promoções da Steam do dia {{ $dadosEstatisticos[0]['executadoEm'] }}</p>

                                <p class="informacoes-tempo p-2">Foram {{ $dadosEstatisticos[0]['jogosCadastrados'] }} jogos processados em {{ $dadosEstatisticos[0]['tempoDeExecucao'] }}</p>

                                <p class="informacoes-eficiencia p-2">{{ $dadosEstatisticos[0]['segundosPorJogo'] }} segundos por jogo.</p>

                            </div>
                        </div>
                    </div>

                </div>
            </section>


            @yield('corpoDaPagina')


        </main>


        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>