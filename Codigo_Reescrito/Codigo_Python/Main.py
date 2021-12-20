"""
Aqui é a partida do carro.
E também quem o desliga.
"""

from Funcoes import Tempo                   # Para calcular o tempo de execução

from os import system as os_system          # Para eu abrir mais de uma instância do Selenium Webdriver ao mesmo tempo
import threading                            # Multi-threading yeah baby!

from Config import enderecoDoCodigo         # Local dos arquivos

from Funcoes import esperarProcessoFechar   # Espera os processos finalizarem

from Funcoes import montarListasTemp        # Monta as listas temporárias feitas

from Funcoes import ordenarLista, escreverPromocoes        # Ordena a lista e a escreve

TicToc = Tempo()


chromeUm = 'ChromeWindow1'
chromeDois = 'ChromeWindow2'


class myThread (threading.Thread):
   def __init__(self, threadID, name, instancia):
      threading.Thread.__init__(self)
      self.threadID = threadID
      self.name = name
      self.instancia = instancia
      
   def run(self):
      print("Starting " + self.name)
      abrirCodigo(enderecoDoCodigo, self.instancia)
      print("Exiting " + self.name)


def abrirCodigo(enderecoDoCodigo, instancia):
    os_system(f'{enderecoDoCodigo}/{instancia}.py')


thread1 = myThread(1, 'Thread-1', chromeUm)
thread2 = myThread(2, 'Thread-2', chromeDois)
thread1.start()
thread2.start()


# verifica se as threads estão em uso
esperarProcessoFechar(thread1, thread2, 30)


listaDeJogos = montarListasTemp()
listaOrdenada = ordenarLista(listaDeJogos)
escreverPromocoes(listaOrdenada)

TicToc.calcularTempoDeExecucao(len(listaOrdenada))