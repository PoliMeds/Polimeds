from datetime import datetime
import requests
import time
import json
import os
import mysqlbot

class TelegramBot:
    def __init__(self):
        token = '5509334373:AAGLwToVyebwhnETn2HNJgNCY2ToVxhrqqE'
        self.url_base = f'https://api.telegram.org/bot{token}/'

    def Iniciar(self):
        update_id = None
        while True:
            atualizacao = self.obter_novas_mensagens(update_id)
            dados = atualizacao["result"]
            if dados:
                for dado in dados:
                    update_id = dado['update_id']
                    mensagem = str(dado["message"]["text"])     
                    chat_id = dado["message"]["from"]["id"]
                    eh_primeira_mensagem = int(
                        dado["message"]["message_id"]) == 1
                    resposta = self.criar_resposta(
                        mensagem, eh_primeira_mensagem)
                    self.responder(resposta, chat_id)

    # Obter mensagens
    def obter_novas_mensagens(self, update_id):
        link_requisicao = f'{self.url_base}getUpdates?timeout=100'
        if update_id:
            link_requisicao = f'{link_requisicao}&offset={update_id + 1}'
        resultado = requests.get(link_requisicao)
        return json.loads(resultado.content)

    # Criar uma resposta
    def criar_resposta(self, mensagem, eh_primeira_mensagem):
        numero_acao = ''
        email = ''
        try: 
            numero_acao, email = mensagem.split(' ')
        except ValueError:
            mensagem = 'help'

        if eh_primeira_mensagem == True or mensagem in ('help', 'Help'):
            return f'''Olá, como posso ajudar? Por favor, envie a opção desejada juntamente ao seu e=mail{os.linesep}1 - acessar meu historico{os.linesep}2 - acessar meu consumo{os.linesep}'''
        if numero_acao == '1':  
            try:
                dados = mysqlbot.historico(email)
                mensagem = f'Seu histórico é\n'
                for nome, data in dados:
                    mensagem += f'{datetime.strftime(data, "%d/%m/%Y às %H:%M")} -> {nome}\n'
                return mensagem
            except Exception as e:
                print(e)
        elif numero_acao == '2':
            try:
                dados = mysqlbot.consumo(email)
                mensagem = f'Seu consumo é\n\n'
                for nome, quantidade, data, compartimento, dia in dados:
                    mensagem += f'-> {data} \n\tNome: {nome}\n\tQuantidade: {quantidade}\n\tCompartimento: {compartimento}\n\tDia da semana:{dia}\n\n'
                return mensagem
            except Exception as e:
                print(e)

        elif numero_acao.lower() in ('obrigado', 'obrigada'):
            return ''' Espero ter ajudado. Cuide-se corretamente!  '''
        
        else:
            return 'Olá, eu sou seu assistente virtual POLIMEDS! E irei te auxiliar no controle de seus medicamentos. Por favor, informe seu email.'



    # Responder
    def responder(self, resposta, chat_id):
        link_requisicao = f'{self.url_base}sendMessage?chat_id={chat_id}&text={resposta}'
        requests.get(link_requisicao)


bot = TelegramBot()
bot.Iniciar()