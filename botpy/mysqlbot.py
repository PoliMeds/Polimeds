from pickle import FALSE, TRUE
import mysql.connector

conexao = mysql.connector.connect(host = 'bpthsv6yjqonmop01p9f-mysql.services.clever-cloud.com',
                                database = 'bpthsv6yjqonmop01p9f',
                                user = 'uliap6wawcwxn2cm',
                                password = '19KlpPYSIUOlMPNrZPSl')

if conexao.is_connected():
    cursor = conexao.cursor()


def autenticacao(email):
    cursor.execute('select email from cliente;')
    r = cursor.fetchall()
    for i in r:
        if email == i[0]:
            return True
    return False
    
def consumo(email):
    conexao = mysql.connector.connect(host = 'bpthsv6yjqonmop01p9f-mysql.services.clever-cloud.com',
                                database = 'bpthsv6yjqonmop01p9f',
                                user = 'uliap6wawcwxn2cm',
                                password = '19KlpPYSIUOlMPNrZPSl')

    if conexao.is_connected():
        cursor = conexao.cursor()
    cursor.execute('SELECT remedio, quantidade, horario, compartimento, dia FROM remedio_do_dia WHERE cliente="'+email+'";')
    r = cursor.fetchall()
    return r

def historico(email):
    conexao = mysql.connector.connect(host = 'bpthsv6yjqonmop01p9f-mysql.services.clever-cloud.com',
                                database = 'bpthsv6yjqonmop01p9f',
                                user = 'uliap6wawcwxn2cm',
                                password = '19KlpPYSIUOlMPNrZPSl')
    if conexao.is_connected():
        cursor = conexao.cursor()
    cursor.execute('SELECT remedio, data_hora FROM historico WHERE cliente="'+email+'" ORDER BY data_hora DESC;')
    r = cursor.fetchall()
    return r


#email = "working@mail.com"
#print(autenticacao(email))
#print(consumo(email))
#print(historico(email))





conexao.close()
cursor.close()