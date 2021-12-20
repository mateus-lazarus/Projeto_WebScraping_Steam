"""
    Processo chrome aberto independentemente para permitir "burlar" o GIL do Python e utilizar de multiprocesamento 
        para acelerar a pesquisa.
    
"""

import Config                                           # Informações básicas

from selenium import webdriver as Swd

from Funcoes import esperar                             # Substituí o time.sleep

from Config import SteamTags                            #   apenas para facilitar o acesso

from WebScraping import lerPagina                       # Irá devolver uma lista de jogos        

from Funcoes import escreverListaTemp                   # Escreve o arquivo temporário da lista de jogos













nomeInstancia = Config.instanciaUm

driver = Swd.Chrome(executable_path=Config.chromeDriver)

linkDaPagina = SteamTags.linkComTag(SteamTags.online_coop)

driver.get(linkDaPagina)
    
listaBonsJogos = lerPagina(driver)

escreverListaTemp(listaBonsJogos, nomeInstancia)