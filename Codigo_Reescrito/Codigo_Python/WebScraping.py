"""
    Bibliotecas para pegar as informações da web e processá-las.
    Todas necessárias.
    
"""

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import selenium.common.exceptions                                   # Para diferenciar exceções
import traceback                                                    # Para identificar os problemas

# As lib estão na ordem em que são chamadas
from Config import descontoMinimo                       # Desconto mínimo
from Funcoes import esperar                             # Substituí o time.sleep
from Funcoes import rolarPagina                         # Continua a descer a página até parar de aparecer novos jogos
from Config import criterioEmVigor                      # Avaliação mínima definida
from Funcoes import verificarReview                     # Verifica a avaliação do jogo mediante critério definido
from Funcoes import lerDesconto                         # Pois está ocorrendo um problema com jogos aparecendo sem preço
from Funcoes import formatarPreco                       # Formata o preço em String para em Float
from Funcoes import carregarPagina                      # Para evitar bagunça no código. Carrega em Json um site
from Config import caracteresMaximos                    # Caracteres máximos da descrição do jogo
from Funcoes import chutarInteiro                       # Substituí o random.randint
from Funcoes import Jogo








def capturarBundle(jogoLink, webdriver) -> list:
    webdriver.execute_script('window.open()')
    webdriver.switch_to.window(webdriver.window_handles[1])
    webdriver.get(jogoLink)
    
    
    if webdriver.current_url.find('agecheck') != -1:
            webdriver.find_element_by_xpath('//*[@id="ageYear"]').click()
            webdriver.find_element_by_xpath(f'//*[@id="ageYear"]/option[{86 - chutarInteiro(0,5)}]').click()
            webdriver.find_element_by_xpath('//*[@id="ageDay"]').click()
            webdriver.find_element_by_xpath(f'//*[@id="ageDay"]/option[{15 - chutarInteiro(0,12)}]').click()
            webdriver.find_element_by_xpath('//*[@id="ageMonth"]').click()
            webdriver.find_element_by_xpath(f'//*[@id="ageMonth"]/option[{6 - chutarInteiro(0,3)}]').click()
            webdriver.find_element_by_xpath(f'//*[@class="agegate_text_container btns"]/a[1]').click()
            esperar(1.2)
    
    try:
        try:
            # Espera para encontrar a foto do jogo, a melhor base para saber se é um BUNDLE ou um JOGO
            ElementWait2 = WebDriverWait(webdriver, 2).until(
                EC.presence_of_element_located((By.XPATH, '//*[@id="gameHeaderImageCtn"]/img'))
            )
            
            jogoDescricao = webdriver.find_element_by_xpath('//*[@id="game_highlights"]/div[1]/div/div[2]').text

        except:
            jogoDescricao = webdriver.find_element_by_xpath('//*[@id="game_highlights"]/div[2]/div/div[2]').text

    except:
        # Não é considero um ERRO MENOR, porque alguns bundles simplesmente não possuem descrição
        jogoDescricao = 'Essa promoção é um BUNDLE, sugiro que entre para ver os jogos um a um'
    
    
    try:
        fotoLink = webdriver.find_element_by_xpath('//*[@id="gameHeaderImageCtn"]/img').get_attribute('src')
        videoLink = webdriver.find_element_by_xpath('//*[@class="highlight_player_item highlight_movie"]').get_attribute('data-webm-hd-source')     
    
    except: 
        # Não é considero um ERRO MENOR, pois nem todos jogos possuem algum vídeo
        try:
            fotoLink = webdriver.find_element_by_xpath('//*[@id="gameHeaderImageCtn"]/img').get_attribute('src')
            videoLink = 0
        except:
            fotoLink = webdriver.find_element_by_xpath('//*[@id="package_header_container"]/img').get_attribute('src')
            videoLink = 0
    
    janelaInicial = webdriver.window_handles[0]
    webdriver.execute_script('window.close()')
    webdriver.switch_to.window(janelaInicial)
    
    
    return videoLink, fotoLink, jogoDescricao




def capturarPagina(jogoLink, jogoID) -> list:
    pagina = carregarPagina(jogoID)
    
    if pagina[jogoID]['success'] == True:
        jogoDescricao = pagina[jogoID]['data']['short_description']
        if len(jogoDescricao) >= caracteresMaximos:
            # assim que atingir a quantidade máxima de caracteres o texto será cortado no primeiro espaço (" ")
            jogoDescricao = jogoDescricao[:jogoDescricao[:caracteresMaximos].rfind(" ")]
            jogoDescricao = '{}...'.format(jogoDescricao)
        
        fotoLink = pagina[jogoID]['data']['header_image']
        
        try:
            videoLink = pagina[jogoID]['data']['movies'][0]['mp4']['max']
        except:
            videoLink = 0
        
    else:
        ERRO_MENOR += 1
        print('Erro. CAPTURAR PAGINA.')
        print(f'Link do jogo : {jogoLink}')
    
    
    return videoLink, fotoLink, jogoDescricao




def capturarInformacoesAdicionais(jogoLink, contagem_de_rodadas, webdriver) -> list:
    if jogoLink.find('app') != -1:
        jogoID = webdriver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{contagem_de_rodadas}]/.').get_attribute('data-ds-appid')
        [videoLink, fotoLink, jogoDescricao] = capturarPagina(jogoLink, jogoID)
        return videoLink, fotoLink, jogoDescricao
    
    else:
        [videoLink, fotoLink, jogoDescricao] = capturarBundle(jogoLink, webdriver)
        return videoLink, fotoLink, jogoDescricao






def listarJogos(descontoMinimo, webdriver) -> list:
    # Definir variáveis de erros
    global ERRO_MAIOR
    global ERRO_MENOR
    ERRO_MAIOR = 0
    ERRO_MENOR = 0      
    
    global numeroJogosBons
    numeroJogosBons = 0
    
    listaJogosBons = []
    
    
    for contagem_de_rodadas in range(0 + 1, numeroJogosLidos + 1):
        x = contagem_de_rodadas     # Para facilitar acesso e ficar mais bonito
        Xpath = XPath_search_results    # Para facilitar acesso e ficar mais bonito
        
        try:
            # Para casos de jogos sem o ícone de avaliação
            try:
                reviewLido = webdriver.find_element_by_xpath(f'{Xpath}/a[{x}]/div[2]/div[3]/span')
                reviewLido = reviewLido.get_attribute('data-tooltip-html')
                reviewLido = reviewLido[:reviewLido.index('<br>')]
                
            except selenium.common.exceptions.NoSuchElementException:
                reviewLido = None
                continue
            
            if verificarReview(reviewLido, criterioEmVigor):
                
                # Para quando o desconto retornar vazio (algo impossível, pois eu já coloquei o critério de apenas mostrar jogos com desconto)
                descontoLido = lerDesconto(Xpath, x, webdriver)
                if descontoLido == False:
                    continue
                
                
                if descontoLido >= descontoMinimo:
                    nomeJogoLido = webdriver.find_element_by_xpath(f'{Xpath}/a[{x}]/div[2]/div[1]/span').text
                    jogoLink = webdriver.find_element_by_xpath(f'{Xpath}/a[{x}]').get_attribute("href")
                    
                    try:
                        [videoLink, fotoLink, jogoDescricao] = capturarInformacoesAdicionais(jogoLink, contagem_de_rodadas, webdriver)
                    
                    except Exception:
                        videoLink = ''
                        fotoLink = ''
                        jogoDescricao = ''
                        
                        ERRO_MENOR += 1
                        #traceback.print_exc()
                        print('\n\n')
                        print(f'Nome do jogo : {nomeJogoLido}')
                        print(f'Erro menor ocorrido. INFORMAÇÕES ADJACENTES. {contagem_de_rodadas}º volta.')
                        print('\n\n')
                        continue
                    
                    
                    try:
                        valoresDoJogo = webdriver.find_element_by_xpath(f'{Xpath}/a[{x}]/div[2]/div[4]/div[2]').text
                        precoAntes = valoresDoJogo[:valoresDoJogo.index('\n')]
                        precoDepois = valoresDoJogo[valoresDoJogo.index('\n') + 1:]
                        
                        # Calcular desconto
                    
                        precoAntes_formatado = formatarPreco(precoAntes)      # para ser possível fazer uma conta matemática
                        precoDepois_formatado = formatarPreco(precoDepois)    # para ser possível fazer uma conta matemática
                        descontoCalculado = 1 - (precoAntes_formatado / precoDepois_formatado)
                        descontoCalculado = descontoCalculado * 100
                        descontoCalculado = '{:.0f}%'.format(descontoCalculado)
                        
                    except Exception:
                        #traceback.print_exc()
                        precoAntes = 'Não há promoção aqui.'
                        precoDepois = webdriver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]/div[2]/div[4]/div[2]').text
                        descontoCalculado = '0%'
                        
                        ERRO_MENOR += 1
                        print('\n\n')
                        print(f'Nome do jogo : {nomeJogoLido}')
                        print(f'Erro menor ocorrido. DESCONTO REAL. {contagem_de_rodadas}º volta.')
                        print('\n\n')
                        continue
                    
                    
                    objetoTemp = Jogo(nomeJogoLido, precoAntes, precoDepois, jogoLink, videoLink, fotoLink, jogoDescricao)
                    listaJogosBons.append(objetoTemp.devolverInfo())
                    numeroJogosBons += 1
                    
            
        except Exception:
            ERRO_MAIOR += 1
            print('\n\n\n\n')
            print(f'Contagem de GRANDES ERROS : {ERRO_MAIOR}.')
            print(f'Ocorrido na {contagem_de_rodadas}º volta.')
            traceback.print_exc()
            print('\n\n\n\n')
            esperar(900)
            #continue
    
    
    print(f'Contagem de PEQUENOS ERROS : {ERRO_MENOR} ')
    print('\n Listagem de Jogos finalizada.')
    webdriver.quit()
    
    return listaJogosBons




def lerPagina(webdriver) -> list:
    # Variáveis para a contagem de jogos lidos
    global numeroJogosLidos
    numeroJogosLidos = 0
    
    global XPath_search_results
    XPath_search_results = '//*[@id="search_resultsRows"]'
    
    
    """
    SCRIPT em javascript para saber a quantidade de jogos achados.
    Todavia é mais inteligente pesquisar por todos os jogos exibidos e então contar a lista
    
    function retornarJogosLidos(ID)
    {
        var elemento = document.getElementById("search_resultsRows");
        var numeroDeFilhos = element.children.length;
        return numeroDeFilhos;
    }
    """
    numeroJogosLidos = rolarPagina(webdriver, XPath_search_results)
    print(f'Foram lidos {numeroJogosLidos} jogos.')
    
    
    return listarJogos(descontoMinimo, webdriver)      # monta uma lista de jogos
