# Funções básicas e adjacentes para rodar o código principal
#  estou separando para que fique fácil tanto a manutenção quanto a leitura do código

import time

def data():
    date = time.strftime('%d-%m-%y')
    return date

def hora():
    hora = time.strftime('%H:%M')
    return hora

def esperar(tempo):
    time.sleep(tempo)



def rolarPagina(webdriver, xpath) -> int:
    jogosMostrados = len(webdriver.find_elements_by_xpath(f'{xpath}/a') )
    
    # Enquanto a quantidade de jogos aumentar, continuará descendo a página
    # Vi que é bom definir um limite de rolagem, pois a steam já está configurada para mostrar por ordem de relevância
    rolagem = 2
    
    while True:
        webdriver.execute_script('window.scrollTo(0,document.body.scrollHeight)')
        esperar(2)
        
        novaContagem = len(webdriver.find_elements_by_xpath(f'{xpath}/a') )
        
        if rolagem == 20:
            return novaContagem
        
        if novaContagem > jogosMostrados :
            jogosMostrados = novaContagem
            rolagem += 1
            continue
        
        return novaContagem



import Config     # informações que definem a execução do todo
import datetime     # para formatar segundos em $H:%M:%S

class Tempo:
    def __init__(self):
        cronometro = int(time.strftime('%H')) * 3600 + int(time.strftime('%M')) * 60 + int(time.strftime('%S'))      # hora do dia em Segundos
        inicio = f'{data()} iniciado às {hora()}'
        self.__cronometro = cronometro
        self.__inicio = inicio
    
    
    def calcularTempoDeExecucao(self, len_listaOrdenada):
        with open(f'{Config.enderecoDaPasta}\Tempo_de_execucao.txt', '+w', encoding='utf-8') as text_file:
            cronometro_desliga = int(time.strftime('%H')) * 3600 + int(time.strftime('%M')) * 60 + int(time.strftime('%S'))      # o momento que encerra a execução
            self.__cronometro = cronometro_desliga - self.__cronometro   # cálculo de tempo transcorrido
            
            text_file.write(f'⭐ {self.__inicio}')
            text_file.write(f'\n Tempo de Execução : {self.__cronometro}s')
            text_file.close()
            
        with open(f'{Config.enderecoDaPasta}\Logger_de_Execução.txt', 'w+', encoding='utf-8') as file_2:    # para manter atualizado os LOGS
            tempoTranscorrido = datetime.timedelta(seconds=self.__cronometro)
            tempoTranscorrido = f'0{tempoTranscorrido}'
            
            arquivoOriginal = file_2.read()
            file_2.write(arquivoOriginal)
            
            file_2.write(f'\n\t{tempoTranscorrido}\t->->\t {len_listaOrdenada} games em {time.strftime("%d/%m/%Y. Finalizado às %H:%M")}. {"{:.3f}".format(self.__cronometro / len_listaOrdenada)}s por jogo \n')
            file_2.close()
        
      

class Jogo:
    def __init__(self, nome_jogo, preco_antes, preco_depois, jogo_link, video_link = '', foto_link = '', jogo_descricao = ''):
        self.__nome = nome_jogo
        self.__precoAntes = formatarPreco(preco_antes)
        self.__precoDepois = formatarPreco(preco_depois)
        self.__link = jogo_link
        self.__video = video_link
        self.__foto = foto_link
        self.__descricao = jogo_descricao
      
    def devolverInfo(self) -> list:
        # Eu gosto de calcular o desconto, pois assim sei REALMENTE quanto de desconto aquele jogo tem
        if self.__precoDepois / self.__precoAntes > 0:
            desconto = (1 - (self.__precoDepois / self.__precoAntes)) * 100
            desconto = '{:.0f}%'.format(desconto)
        else:
            desconto = 'Erro.'
            
        self.__precoAntes = '{0:05.2f}'.format(self.__precoAntes)
        self.__precoAntes = 'R$ {}'.format(self.__precoAntes)
        self.__precoDepois = '{0:05.2f}'.format(self.__precoDepois)
        self.__precoDepois = 'R$ {}'.format(self.__precoDepois)
        
        informacoes = [
            self.__nome,
            self.__precoAntes,
            self.__precoDepois,
            desconto,
            self.__video,
            self.__foto,
            self.__link,
            self.__descricao
                ]
        
        
        return informacoes



def formatarPreco(precoEmString) -> float:
    precoFormatado = float(((precoEmString.replace('R$','')).replace(' ','')).replace(',','.'))
    precoFormatado = '{:.2f}'.format(precoFormatado)    # garantindo que todo número tenha 2 casas decimais
    return float(precoFormatado)



def verificarReview(review, criterioEmVigor):
    reviewMinimo = Config.criteriosDeReview.index(criterioEmVigor) + 1
    for i in range(0, reviewMinimo):
        if review in Config.criteriosDeReview[i]:
            return True
    
    return False



def lerDesconto(Xpath, x, webdriver):
    # Tô fazendo essa função, pois está ocorrendo um problema com preços sumindo de alguns jogos e está causando ERRO MAIOR
    #   Também aproveitarei, pois essa função me permitirá suprimir mais erros externos futuramente
    
    try:
        descontoLido = webdriver.find_element_by_xpath(f'{Xpath}/a[{x}]//*[@class="col search_price_discount_combined responsive_secondrow"]/div[1]/span').text
        descontoLido = descontoLido.replace('-','').replace('%','')
        descontoLido = int(descontoLido)
        return descontoLido
    
    except:
        return False



from requests import get
from json import loads

def carregarPagina(jogoID):
    # Faz um request e carrega em json as informações do site
    # Uso o link da api, pois ela devolve as informações sem dor de cabeça para o JSON
    
    formatoLink = f'http://store.steampowered.com/api/appdetails?appids={jogoID}'
    
    pagina = get(formatoLink)
    status_code = pagina.status_code
    content = pagina.content
    if status_code == 200:
        return loads(content)
    
    else:
        pagina = get(formatoLink)
        status_code = pagina.status_code
        content = pagina.content
        
        if status_code == 200:
            return loads(content)
        
        else:
            print(f'CARREGAR PÁGINA. STATUS CODE : {pagina.status_code}')
            return None
    
    
    
from random import randint

def chutarInteiro(início, limite) -> int:
    """
    Para permitir a atualização para uma lib que realmente possa escolher números randomicamente
    
    conjuntoUniverso = x | início <= x < limite
    """  
    
    return randint(início, limite)



from json import dump

def escreverListaTemp(listaJogosBons, nomeInstancia) -> None:
    with open(f'{Config.enderecoDaPasta}/{nomeInstancia}-Temporário.txt', 'w', encoding='utf-8') as text_file:
        dump(listaJogosBons, text_file, ensure_ascii=False)
        text_file.close()



from os import remove as os_remove

def montarListasTemp() -> list:
    with open(f'{Config.enderecoDaPasta}/Webdriver_1-Temporário.txt', 'r', encoding='utf-8') as text_file:
        listaTemp1 = loads(text_file.read())
        text_file.close()
    os_remove(f'{Config.enderecoDaPasta}/Webdriver_1-Temporário.txt')
    
    
    with open(f'{Config.enderecoDaPasta}/Webdriver_2-Temporário.txt', 'r', encoding='utf-8') as file_2:
        listaTemp2 = loads(file_2.read())
        file_2.close()
    os_remove(f'{Config.enderecoDaPasta}/Webdriver_2-Temporário.txt')


    for element in listaTemp1:
        if element not in listaTemp2:
            listaTemp2.append(element)
            
    listaFinal = listaTemp2
    return listaFinal



# Ordena em * ordem decrescente de desconto *
def ordenarLista(listaNaoOrdenada) -> list:
    #   modelo do dicionário :
    #   [nome, precoAntes, precoDepois, desconto, video, foto, link, descricao] 

    listaOrdenada = sorted(listaNaoOrdenada, key= lambda x: x[3], reverse=True)
    return listaOrdenada

    

def escreverPromocoes(listaOrdenada, debugger = 1) -> None:
    #   modelo do dicionário :
    #   [nome, precoAntes, precoDepois, desconto, video, foto, link, descricao] 
    
    nomeDoArquivo = 'Promocoes_da_Steam'
    
    with open(f'{Config.enderecoDaPasta}\{nomeDoArquivo}.txt', 'w', encoding='utf-8') as text_file:
        
        text_file.write(f'\t\t\t\t\tPromoções de {data()}\n')
        text_file.write(f'\nJogos bons em promoção : {len(listaOrdenada)}\n*')
        text_file.write('\n\n\n\n')
        text_file.write('\t***\tJOGOS BONS EM PROMOÇÃOO\t***')
        text_file.write('\n\n')
    
        for x in range(0, len(listaOrdenada)):
            tempNome = listaOrdenada[x][0]
            tempPrecoAntes = listaOrdenada[x][1]
            tempPrecoDepois = listaOrdenada[x][2]
            tempDesconto = listaOrdenada[x][3]
            text_file.write(f'{tempNome}\t\n\t{tempPrecoAntes}\t-->\t{tempPrecoDepois} || {tempDesconto}\n')
        text_file.close()
    
    if debugger == 1:
        with open(f'{Config.enderecoDaPasta}\Debugger.txt', 'w', encoding='utf-8') as file_2:
            file_2.write(f'Contagem de entradas :  {len(listaOrdenada)}')
            file_2.write('\n\n\n\n')
            for x in range(0, len(listaOrdenada)):
                dump(listaOrdenada[x], file_2, ensure_ascii=False)
                file_2.write('\n\n')
                
            file_2.close()
            


def esperarProcessoFechar(thread1, thread2, esperaInicial = 30) -> None:
    # Irá criar um loop de verificação COM AS THREADS
    
    # espera inicial
    esperar(esperaInicial)
    print('Iniciando processo de espera.')
    
    
    while True:
        if thread1.is_alive() == False and thread2.is_alive() == False:
            break