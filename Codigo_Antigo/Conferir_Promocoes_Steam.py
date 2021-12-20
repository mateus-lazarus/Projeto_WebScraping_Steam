import asyncio
import json
from selenium import webdriver as Swd
from selenium.webdriver.common.keys import Keys as Sk
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
from time import localtime, strftime
import random
from json import dumps, loads
from requests import get
import discord
from discord.ext import commands
import traceback                                        # Para não dar uns problemas
import tracemalloc


#Data e Horas
def Date():
    Date = time.strftime('%d-%m-%y', time.localtime())
    return Date
def Horas():
    Horas = time.strftime('%H:%M', time.localtime())
    return Horas
#Date = time.strftime('%d-%m-%y', time.localtime())
#Horas = time.strftime('%H:%M', time.localtime())

Swarmfire_Id = // Código de Acesso
DiscordEnterprise_Id = // Código de Acesso
IntegerDescount = 75
ValorMáximoDosJogos = 20


LocalData = // Local no computador
# Para calcular o tempo de execução
with open(f'{LocalData}Tempo de Execução.txt', 'w+') as f:
    h1 = int(time.strftime('%H')) * 3600 + int(time.strftime('%M')) * 60 + int(time.strftime('%S'))
    w1 = [ time.strftime('%H:%M:%S'), h1 ]
    f.write(dumps(w1))
    f.close()

Games_Name = []
Games_Prices_Before = []
Games_Prices_After = []
Total_Data = {}
Total_Number_of_Games = []

# Txt com Promoções do Dia
def FazerTexto(nome, toggle = None):
    #Ordenando!
    OrdemDeDesconto(Total_Data)

    with open(f'{LocalData}Promoções_{nome}.txt', 'w', encoding='utf8') as f:
        f.write(f'\t\t\t\t\tPromoções de {Date()}\n')
        Good_above_Games_Percentage = format(   float(  ( Total_Number_of_Good_Games/len(Total_Number_of_Games ))*100  )   ,".0f")
        f.write(f'Jogos em promoção : {len(Total_Number_of_Games)}\nJogos bons em promoção : {Total_Number_of_Good_Games}\nUma relação de * {Good_above_Games_Percentage}% * \n\n\n')
        f.write('\n\n\t***\tJOGOS BONS EM PROMOÇÃOO\t***\n\n')
        print(Total_Number_of_Good_Games)
        print(len(Games_Name))
        for x in range (0, Total_Number_of_Good_Games):
            DescontoAtual = Total_Data[Games_Name[x]][2]
            f.write(f'{Games_Name[x]}\t\n\t{Games_Prices_Before[x]}\t-->\t{Games_Prices_After[x]} || {DescontoAtual}\n')
        f.close()
    
    if toggle == 1:
        with open(f'{LocalData}Debug_{nome}.txt', 'w', encoding='utf8') as f:
            #for x in range (0, Total_Number_of_Good_Games):
            #    f.write(f'{x}--{Games_Name[x]}\t\n\t{x}--{Games_Prices_Before[x]}\t-->\t{x}--{Games_Prices_After[x]}\n')
            f.write(f'\n\nGames Name -> {len(Games_Name)}\n\nGames Prices Before -> {len(Games_Prices_Before)}\n\nGames Prices After -> {len(Games_Prices_After)}')
            f.write(f'\n\n{Games_Name} \n/-/\n  {Games_Prices_Before} \n/-/\n  {Games_Prices_After}')
            f.write(f'\n\n\nTotal_Data keys -> {len(Total_Data.keys())}\n\n{Total_Data}')
            f.close()

    #EnviarNoDiscord()

# Ordena em Ordem Decrescente de Desconto
def OrdemDeDesconto(Dicionário):
    """
    modelo do dicionário :
    {GN1 : [ GP_B, GP_A, D_P, {'video':GV_LINK, 'photo':GP_LINK, 'steam':GS_LINK, 'description':GD} ] }
    """
    ListOfTuples = []

    for element in Dicionário.items():
        # Descount Percentage
        D_P = list(element)[1][2]
        D_P = int(D_P.replace('%',''))
        #Game Name
        G_N = list(element)[0]
        ListOfTuples.append([G_N, D_P])

    ListOfTuples = sorted(ListOfTuples,key= lambda x: x[1],reverse=True)    # Ordem Descrescente de Desconto


    global Games_Name
    Games_Name = []

    for element in ListOfTuples:
        Games_Name.append(element[0])

# Pega Video ou Foto do jogo
def GameVideoFunction(driver, G_link, x):
    global Game_Video
    global Game_Photo
    global Game_Description

    #print(f'\n\nThe current windows is **{driver.current_window_handle}**')
    #print(f'Lista de Handles : \n{driver.window_handles}\n\n')
    appid = driver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]/.').get_attribute('data-ds-appid')
    if G_link.find('app') != -1:
        response = get(f'http://store.steampowered.com/api/appdetails?appids={appid}').content
        json_file = loads(response)
        if json_file[appid]['success'] == True :
            #Game_Name = json_file[appid]['data']['name']
            #Game_Price = [  json_file[appid]['data']['price_overview']['initial_formatted']  ,  json_file[appid]['data']['price_overview']['final_formatted']  ,  json_file[appid]['data']['price_overview']['discount_percent']  ]
            Game_Description = json_file[appid]['data']['short_description']
            if len(Game_Description) >= 300:
                Game_Description = f'{Game_Description[:Game_Description[:300].rfind(" ")]}...'
            Game_Photo = json_file[appid]['data']['header_image']
            try:
                Game_Video = json_file[appid]['data']['movies'][0]['mp4']['max']
            except:
                Game_Video = 0
        else:
            print('Erro no Glink_Find(\"app\") !')
            pass

    else:
        driver.execute_script("window.open()")
        driver.switch_to.window(driver.window_handles[1])
        driver.get(G_link)


        if driver.current_url.find('agecheck') != -1:
            driver.find_element_by_xpath('//*[@id="ageYear"]').click()
            driver.find_element_by_xpath(f'//*[@id="ageYear"]/option[{86 - random.randint(0,5)}]').click()
            driver.find_element_by_xpath('//*[@id="ageDay"]').click()
            driver.find_element_by_xpath(f'//*[@id="ageDay"]/option[{15 - random.randint(0,12)}]').click()
            driver.find_element_by_xpath('//*[@id="ageMonth"]').click()
            driver.find_element_by_xpath(f'//*[@id="ageMonth"]/option[{6 - random.randint(0,3)}]').click()
            driver.find_element_by_xpath(f'//*[@class="agegate_text_container btns"]/a[1]').click()
            time.sleep(1.2)
        
        
        try:
            try:
                # Espera para encontrar a foto do jogo, a melhor base para saber se é um BUNDLE ou um JOGO
                ElementWait2 = WebDriverWait(driver, 2).until(
                    EC.presence_of_element_located((By.XPATH, '//*[@id="gameHeaderImageCtn"]/img'))
                )

                Game_Description = driver.find_element_by_xpath('//*[@id="game_highlights"]/div[1]/div/div[2]').text
                print(Game_Description)
            except:
                # Espera para encontrar a foto do jogo, a melhor base para saber se é um BUNDLE ou um JOGO
                ElementWait2 = WebDriverWait(driver, 2).until(
                    EC.presence_of_element_located((By.XPATH, '//*[@id="gameHeaderImageCtn"]/img'))
                )

                Game_Description = driver.find_element_by_xpath('//*[@id="game_highlights"]/div[2]/div/div[2]').text
                print(Game_Description)

        except:
            # Espera para encontrar a foto do BUNDLE
            ElementWait2 = WebDriverWait(driver, 2).until(
                EC.presence_of_element_located((By.XPATH, '//*[@id="package_header_container"]/img'))
            )

            Game_Description = 'Essa promoção é um BUNDLE, sugiro que entre para ver os jogos um a um'
            print(Game_Description)
        

        try:
            Game_Photo = driver.find_element_by_xpath('//*[@id="gameHeaderImageCtn"]/img').get_attribute('src')
            Game_Video = driver.find_element_by_xpath('//*[@class="highlight_player_item highlight_movie"]').get_attribute('data-webm-hd-source')     
            #print('Link para o vídeo : ' + Game_Video)
        except:
            try:
                Game_Photo = driver.find_element_by_xpath('//*[@id="gameHeaderImageCtn"]/img').get_attribute('src')
                Game_Video = 0
                #print('Link para a imagem : ' + Game_Video)
            except:
                Game_Photo = driver.find_element_by_xpath('//*[@id="package_header_container"]/img').get_attribute('src')
                Game_Video = 0
                #print('Link para a imagem do bundle : ' + Game_Video)
        print(Game_Photo)
        print(Game_Video)
        d1 = driver.window_handles[0]
        driver.execute_script("window.close()")
        driver.switch_to.window(d1)

# Conferir se a mensagem está fixada ou não
def CheckIfIsItOkayToDelete(msg):                    # Para não apagar mensagens fixadas
    if not msg.pinned and msg.author.id == DiscordEnterprise_Id:
        return True
    else:
        if not msg.pinned and msg.author.id == Swarmfire_Id:
            print('Apagando mensagem do Swarmfire hihihi')
            return True
        else:
            return False



# Enviar no Canal
def EnviarNoDiscord():

    # token do bot
    Token_Bot = // Token do bot

    client = commands.Bot(command_prefix = '$@')

    #author_icons_urls
    author_icon1 = 'https://cdn.discordapp.com/avatars/832502936600182794/a_138e46f90bf4fd5f99601d53c71d675b.gif?size=128'
    #footers
    footer1 = 'By Swarmfire to my Jian [ 鹣 ]'
    footer2 = ''
    footer3 = 'Para entrar no jogo, basta clicar no nome dele!'
    #author_url
    author_url1 = 'https://discord.com/api/oauth2/authorize?client_id=827543776502612009&permissions=257105&scope=bot'

    @client.event
    async def on_ready():
        canalteste = client.get_channel(853705712071606272)
        CanaisProgramados = ['811761441899151391', '796832351094308944', '856220846778875994']
        for x in range(0, len(CanaisProgramados)):
            temp_channel = client.get_channel(int(CanaisProgramados[x]))
            try:
                await temp_channel.purge(limit=80, check=CheckIfIsItOkayToDelete)
                await asyncio.sleep(2)
                await temp_channel.purge(limit=80, check=CheckIfIsItOkayToDelete)
                await asyncio.sleep(2)
            except discord.Forbidden or discord.NoMoreItems:
                pass
            try:
                for x in range(0, len(Total_Data.keys())):
                    embed2=discord.Embed(title=f"{Games_Name[x]}", url=f'{Total_Data[Games_Name[x]][3]["steam"]}', description=f'{Total_Data[Games_Name[x]][3]["description"]}')
                    embed2.set_author(name=f"Promoções de {Date()} às {Horas()}", url=author_url1, icon_url=author_icon1)
                    #embed2.set_thumbnail(url='https://cdn.discordapp.com/avatars/703433629413539851/6c998aca6ca1d117706ab8ee138a321d.png?size=128')
                    embed2.set_image(url=f'{Total_Data[Games_Name[x]][3]["photo"]}')
                    embed2.add_field(name=f'*Preço do Game com* **{Total_Data[Games_Name[x]][2]}** *de Desconto*', value=f'{Total_Data[Games_Name[x]][0]}  →→  {Total_Data[Games_Name[x]][1]}', inline=True)
                    if Total_Data[Games_Name[x]][3]["video"] != 0:
                        embed2.add_field(name="Vídeo do Jogo : ", value=Total_Data[Games_Name[x]][3]["video"], inline=True)
                    embed2.set_footer(text=footer2)
                    MessageID = await temp_channel.send(embed=embed2)
                    time.sleep(0.5)
                    SendMessagesIDs.update({Date():[MessageID]})
                    print(x)

                MessageID1 = await ctx.channel.send('Tudo okay, parabéns hehe', delete_after=5)
                embed1=discord.Embed(title=f"Se você der sorte e encontrar um *umpa-lumpa* no trajeto avise aos demais, por favor! \n\t || pois precisaremos te estudar... ||", url='', description=f'Foram selecionados **{len(Games_Name)} jogos** da Steam que custam **menos de {ValorMáximoDosJogos} reais**, com **excelente avaliação e MUITO DESCONTO** hehe. Os critérios utilizados são **Coop** e **Multiplayer** ')
                embed1.set_author(name="Bem vindos à fantástica fábrica de promoções", url=author_url1, icon_url=author_icon1)
                embed1.set_image(url=f'https://i.makeagif.com/media/9-01-2018/rA4YF9.gif')
                embed1.set_footer(text=footer3)
                MessageID2 = await temp_channel.send(embed=embed1)
                SendMessagesIDs.update({Date():[MessageID1, MessageID2]})

            except:
                print(f'Houve um problema... {client.latency}', delete_after=5)

        print(f'\n\nForam atualizados {len(CanaisProgramados)} canais com as novidades!')
        print(f'\nDe {int(len(client.guilds)) - 1} servers em que estou, foram atualizados {len(CanaisProgramados)}')

    @client.command()
    async def Total(ctx):
        await ctx.channel.send(f'Há **{len(Total_Data.keys())}** jogos cadastrados', delete_after=5)
        await asyncio.sleep(5)
        await ctx.message.delete()

    @client.command()
    async def Canais(ctx):
        CanalDeTeste = 853705712071606272
        CanalDoMateus = 811761441899151391
        CanalDaWit = 796832351094308944
        CanalDoNaka = 856220846778875994
        await ctx.channel.send(f'Canais em que estou : {len(client.guilds)}\n\nCanais cadastrados na Database : \n\n\tCanal do Mateus\t>>\t {CanalDoMateus}\n\tCanal da Wit\t>>\t {CanalDaWit}\n\tCanal de Teste\t>>\t {CanalDeTeste}\n\tCanal do Naka\t>>\t {CanalDoNaka}', delete_after=10)
        await asyncio.sleep(5)
        await ctx.message.delete()

    @client.command(pass_context = True)
    async def clear(ctx, number, channel):
        number = int(number)
        channel = int(channel)
        ChosenChannel = client.get_channel(channel)
        await ctx.channel.send('Estarei apagando hehehe', delete_after=5)
        if number >= 100:
            for x in range(0,(number//25)):
                await ChosenChannel.purge(limit=75, check=CheckIfIsItOkayToDelete)
        else:
            await ChosenChannel.purge(limit=number, check=CheckIfIsItOkayToDelete)
        await asyncio.sleep(5)
        await ctx.message.delete()            

    @client.command()
    async def Stop(ctx):
        await ctx.channel.send('Desligando... Byeeee', delete_after=3)
        await asyncio.sleep(3)
        await ctx.message.delete()
        await client.logout()

    @client.command(pass_context = True)
    async def Okay(ctx, CanalID):    
        global SendMessagesIDs                                               
        SendMessagesIDs = {}
        try:
            #CanalID = ctx.message.content[ctx.message.content.index('Okay ')+5:]
            await ctx.channel.send(CanalID, delete_after=5)
            CanalDesejado = client.get_channel(int(CanalID))

            #CanalDesejado = client.get_channel(CanalDoMateus)
            #print(f'Total Number : {Total_Number_of_Good_Games}')

            for x in range(0, len(Total_Data.keys())):
                embed2=discord.Embed(title=f"{Games_Name[x]}", url=f'{Total_Data[Games_Name[x]][3]["steam"]}', description=f'{Total_Data[Games_Name[x]][3]["description"]}')
                embed2.set_author(name=f"Promoções de {Date()} às {Horas()}", url=author_url1, icon_url=author_icon1)
                #embed2.set_thumbnail(url='https://cdn.discordapp.com/avatars/703433629413539851/6c998aca6ca1d117706ab8ee138a321d.png?size=128')
                embed2.set_image(url=f'{Total_Data[Games_Name[x]][3]["photo"]}')
                embed2.add_field(name=f'*Preço do Game com* **{Total_Data[Games_Name[x]][2]}** *de Desconto*', value=f'{Total_Data[Games_Name[x]][0]}  →→  {Total_Data[Games_Name[x]][1]}', inline=True)
                if Total_Data[Games_Name[x]][3]["video"] != 0:
                    embed2.add_field(name="Vídeo do Jogo : ", value=Total_Data[Games_Name[x]][3]["video"], inline=True)
                embed2.set_footer(text=footer2)
                MessageID = await CanalDesejado.send(embed=embed2)
                #if Total_Data[Games_Name[x]][3]["video"] != 0:
                    #await CanalDesejado.send(f'Vídeo de exposição do jogo : \n || {Total_Data[Games_Name[x]][3]["video"]} ||')
                time.sleep(0.5)
                SendMessagesIDs.update({Date():[MessageID]})
                print(x)

            MessageID1 = await ctx.channel.send('Tudo okay, parabéns hehe', delete_after=5)
            embed1=discord.Embed(title=f"Se você der sorte e encontrar um *umpa-lumpa* no trajeto avise aos demais, por favor! \n\t || pois precisaremos te estudar... ||", url='https://discord.gg/studybr', description=f'Foram selecionados **{len(Games_Name)} jogos** da Steam que custam **menos de {ValorMáximoDosJogos} reais**, com **excelente avaliação e MUITO DESCONTO** hehe. Os critérios utilizados são **Coop** e **Multiplayer** ')
            embed1.set_author(name="Bem vindos à fantástica fábrica de promoções", url=author_url1, icon_url=author_icon1)
            embed1.set_image(url=f'https://i.makeagif.com/media/9-01-2018/rA4YF9.gif')
            embed1.set_footer(text=footer3)
            MessageID2 = await CanalDesejado.send(embed=embed1)
            SendMessagesIDs.update({Date():[MessageID1, MessageID2]})
            await asyncio.sleep(7)
            await ctx.message.delete()

        except:
            await ctx.channel.send(f'Houve um problema... {client.latency}', delete_after=5)
            await asyncio.sleep(7)
            await ctx.message.delete()





    client.run('// Token')


driver1 = Swd.Chrome(executable_path=r"C:/Python/SeleniumPackages/chromedriver.exe")
driver2 = Swd.Chrome(executable_path=r"C:/Python/SeleniumPackages/chromedriver.exe")
link1 = f'https://store.steampowered.com/search/?maxprice={ValorMáximoDosJogos}&tags=1685&specials=1'
link2 = f'https://store.steampowered.com/search/?maxprice={ValorMáximoDosJogos}&tags=3859&specials=1'
driver1.get(link1)
driver2.get(link2)
for x in range(0, 20):
    driver1.execute_script("window.scrollTo(0,document.body.scrollHeight)")
    driver2.execute_script("window.scrollTo(0,document.body.scrollHeight)")
    time.sleep(0.5)

def PegaPegaPromo(link, driver):
    global Total_Number_of_Games
    global Total_Number_of_Good_Games
    global Games_Name
    global Games_Prices_After
    global Games_Prices_Before
    global Total_Data
    Major_Error_Count = 0
    Minor_Error_Count = 0
    # passei para fora da função, para que ambos chromes possam carregar a página da steam ao mesmo tempo
    #driver.get(link)
    #for x in range(0, 10):
    #    driver.execute_script("window.scrollTo(0,document.body.scrollHeight)")
    #    time.sleep(1)

    try:
        Total_Number_Read = 0
        Total_Number_of_Good_Games = 0
        print('\n\n')
        for x in range(1, 300):
            XPath = '//*[@id="search_resultsRows"]'
            Teste1 = driver.find_element_by_xpath(f'{XPath}/a[{x}]')
            Total_Number_Read += 1
            print(f'\r Número de Games Contados : {Total_Number_Read}', end='')
            #time.sleep(0.2)
    except:
        print('\n\n... prontinho a análise...\n\n')
        pass
    time.sleep(0.5)
    print('\n... working...\n')
    print('\n\nO critério é : \"Muito positivas\"')
    for x in range(1, Total_Number_Read + 1):
        try:
            #time.sleep(0.5)
            Confirmação1 = driver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]/div[2]/div[3]/span')
            Confirmação1 = Confirmação1.get_attribute('data-tooltip-html')
            Confirmação1 = Confirmação1[:Confirmação1.index('<br>')]
            print('\r                                                                         ')
            print(f'\rO rate sendo lido é : {Confirmação1}')
            #  ↓
            GN1 = (driver.find_element_by_xpath(f'{XPath}/a[{x}]/div[2]/div[1]/span').text)
            #print(GN1)
            #  ↑
            if GN1 not in Total_Number_of_Games:
                Total_Number_of_Games.append(GN1)
            if Confirmação1 == 'Muito positivas' or Confirmação1 == 'Extremamente positivas':
                w1 = driver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]//*[@class="col search_price_discount_combined responsive_secondrow"]/div[1]').text
                print(w1)
                w1 = int(w1.replace('-','').replace('%',''))
                if w1 >= IntegerDescount:
                    # ↑
                    if GN1 not in Games_Name:
                        Minor_Error_Count += 1
                        # Para esperar o elemento ser carregado na troca de abas do Google
                        ElementWait1 = WebDriverWait(driver, 5).until(
                            EC.presence_of_element_located((By.XPATH, f'//*[@id="search_resultsRows"]/a[{x}]'))
                        )
                        try:
                            SteamGameLink = driver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]').get_attribute("href")
                            GameVideoFunction(driver, SteamGameLink, x)
                        except:
                            GV_LINK = 0
                            GP_LINK = 2
                            GS_LINK = 3
                            GD = 4
                        


                        Games_Name.append(GN1)
                        #print((driver.find_element_by_xpath(f'{XPath}/a[{x}]/div[2]/div[1]/span').text))
                        TempVariable = (driver.find_element_by_xpath(f'{XPath}/a[{x}]/div[2]/div[4]/div[2]').text)
                        print('')
                        
                        print(TempVariable)
                        try:
                            GP_B = TempVariable[:TempVariable.index('\n')]
                            print(f'GP_B = {GP_B}')
                            Games_Prices_Before.append(GP_B)
                            #if GP_B not in Games_Prices_Before:
                                #Games_Prices_Before.append(GP_B)
                                #print(TempVariable[:TempVariable.index('\n')-1])
                            GP_A = TempVariable[TempVariable.index('\n')+1:]
                            print(f'GP_A = {GP_A}')
                            Games_Prices_After.append(GP_A)
                            #if GP_A not in Games_Prices_Before:
                                #Games_Prices_After.append(GP_A)
                                #print(TempVariable[TempVariable.index('\n')+1:])
                            # Calcular a porcentagem de disconto
                            GP_B_2 = float(((GP_B.replace('R$','')).replace(' ','')).replace(',','.'))
                            print(f'calculando preço de {GP_B_2}')
                            GP_A_2 = float(((GP_A.replace('R$','')).replace(' ','')).replace(',','.'))
                            print(f'calculando preço de {GP_A_2}')
                            Discount_Percentage = (1 - (GP_A_2 / GP_B_2))  * 100
                            Discount_Percentage = f'{format(Discount_Percentage, ".0f")}%'

                        except:
                            GP_B = 'Não Há Promoção Aqui'
                            print(f'GP_B = {GP_B}')
                            Games_Prices_Before.append(GP_B)
                            #print('Não Há Promoção Aqui')
                            GP_A = (driver.find_element_by_xpath(f'//*[@id="search_resultsRows"]/a[{x}]/div[2]/div[4]/div[2]').text)
                            print(f'GP_A = {GP_A}')
                            Games_Prices_After.append(GP_A)
                            #if GP_A not in Games_Prices_Before:
                                #Games_Prices_After.append(GP_A)
                                #print(driver.find_element_by_xpath('//*[@id="search_resultsRows"]/a[{x}]/div[2]/div[4]/div[2]').text)
                            # Calcular a porcentagem de disconto
                            Discount_Percentage = f'0%'


                        # Aqui se simplifica o Discount_Percentage
                        D_P = Discount_Percentage
                        # Aqui se simplifica o link para vídeo, imagem, link do jogo e descrição
                        GV_LINK = Game_Video
                        GP_LINK = Game_Photo
                        GS_LINK = SteamGameLink
                        GD = Game_Description
                        
                        # Colocar as informações no Dicionários
                        Total_Data.update({GN1:[GP_B, GP_A, D_P, {'video':GV_LINK, 'photo':GP_LINK, 'steam':GS_LINK, 'description':GD}]})
                        #Total_Data.update({GN1:[GP_B, GP_A, D_P]})
                        Total_Number_of_Good_Games += 1
            else:
                pass
        except:
            #print(Total_Number_Read)
            Major_Error_Count += 1
            print(f'Major Error Count : {Major_Error_Count}')
            pass
    print(f'Minor Error Count : {Minor_Error_Count}')
    print(len(Total_Data.keys()))
    print('\n\n TUDO PRONTOOO ! ! !')
    driver.quit()

# Arrumando Lista De Jogos Em Promoções por valor



PegaPegaPromo(link1, driver1)
PegaPegaPromo(link2, driver2)
FazerTexto(f'PromoçõesSteam', 1)
with open(f'{LocalData}Tempo de Execução.txt', 'r') as f:
    h1 = int(time.strftime('%H')) * 3600 + int(time.strftime('%M')) * 60 + int(time.strftime('%S'))
    w2 = loads(f.read())
    h2 = w2[1]
    h3 = h1 - h2
    Hora = lambda x : x // 3600
    Minuto = lambda x : (x % 3600) // 60
    Segundos = lambda x : ((x % 3600) % 60)
    h3_Hora = '{:02d}'.format(Hora(h3))
    h3_Minuto = '{:02d}'.format(Minuto(h3))
    h3_Segundos = '{:02d}'.format(Segundos(h3))
    h3_Delta = f'{h3_Hora}:{h3_Minuto}:{h3_Segundos}'
with open(f'{LocalData}Tempo de Execução.txt', 'w+') as f:
    f.write(f'Tempo de execução : {h3_Delta}')
    with open(f'{LocalData}Logger_de_Execução.txt', 'r') as g:
        LastText = g.read()
    with open(f'{LocalData}Logger_de_Execução.txt', 'w+') as g:
        g.write(LastText)
        g.write(f'\n\t{h3_Delta}\t->->\t {len(Total_Data.keys())} games em {strftime("%d/%m/%Y. Finalizado às %H:%M")}. {format((h3 / len(Total_Data.keys()) ), ".3f")}s por jogo \n')
    f.close()
#EnviarNoDiscord()



























