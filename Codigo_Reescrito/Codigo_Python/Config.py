
# Arquivo para definições do código que irá rodar, assim não será necessário mexer em nada do "hard-code" para alterações
#   de comportamento básicas


descontoMinimo = 80   
valorMaximo = 20      # dos jogos, já considerando desconto
criteriosDeReview = [
    # Em ordem da melhor para a pior. Fará sentido o uso de ARRAY à frente
    'Extremamente positivas',
    'Muito positivas',
    'Ligeiramente positivas',
    'Neutras'
    ]

criterioEmVigor = criteriosDeReview[2]


enderecoDaPasta = r'C:\Users\Pichau\Documents\Blocos de Anotações do OneNote\SiteSteam'
enderecoDoCodigo = r'C:\Users\Pichau\Desktop\Python\Area_de_Testes\Programas\Reescrevendo_Código\Projeto_WebScraping_Steam\Codigo_Reescrito\Codigo_Python'
chromeDriver = r'C:\Python\SeleniumPackages\chromedriver.exe'

# Caracteres máximos para a descrição do jogo
caracteresMaximos = 300




class SteamTags:
    multiplayer = 3859
    action = 19
    online_coop = 3843
    coop = 1685
    strategy = 9
    software = 8013
    
    def linkComTag(tag1, tag2 = None, tag3 = None):
        if tag3 != None:
            steamLink = 'https://store.steampowered.com/search/?maxprice={}&tags={}%2C{}%2C{}&specials=1'.format(valorMaximo, tag1, tag2, tag3)
        
        elif tag2 != None:
            steamLink = 'https://store.steampowered.com/search/?maxprice={}&tags={}%2C{}&specials=1'.format(valorMaximo, tag1, tag2)
            
        elif tag1 != None:
            steamLink = 'https://store.steampowered.com/search/?maxprice={}&tags={}&specials=1'.format(valorMaximo, tag1)
            
        else:
            import traceback
            traceback.print_exception()
            pass

        return steamLink


# Nome das instâncias que serão abertas para utilizar do multiprocessamento
instanciaUm = 'Webdriver_1'
instanciaDois = 'Webdriver_2'


