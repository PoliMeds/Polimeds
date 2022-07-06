-- Cria o banco de dados e tabelas utilizadas durante o projeto 

create schema polimeds;
use polimeds;

create table cliente (
    email varchar (100) not null,
    senha varchar (100) not null,
    nome varchar (100) not null,
    ddd integer not null,
	telefone integer not null,
    primary key (email)
);

create table caixinha (
	id integer not null,
    nome varchar (100) not null,
	total_slots integer not null,
    dono varchar (100) not null,
	primary key (id),
    foreign key (dono) references cliente(email)
);

create table dias_semana(
	nome varchar (7),
    primary key (nome)
);

create table estoque (
    id integer AUTO_INCREMENT,
    cliente varchar (100),
    remedio varchar (100),
    quantidade integer,
    vencimento date,
    primary key (id),
    foreign key (cliente) references cliente(email)
);

create table remedio_do_dia (
    id integer AUTO_INCREMENT,
    cliente varchar (100),
    dia varchar (7),
    remedio varchar (100),
    quantidade integer,
    horario time,
    compartimento integer,
    primary key (id),
    foreign key (cliente) references cliente(email),
    foreign key (dia) references dias_semana(nome)
);

create table historico (
    remedio varchar (100),
    data_hora datetime,
    cliente varchar (100),
    foreign key (cliente) references cliente(email)
);

-- insert dias da semana
INSERT INTO dias_semana VALUES("domingo");
INSERT INTO dias_semana VALUES("segunda");
INSERT INTO dias_semana VALUES("terca");
INSERT INTO dias_semana VALUES("quarta");
INSERT INTO dias_semana VALUES("quinta");
INSERT INTO dias_semana VALUES("sexta");
INSERT INTO dias_semana VALUES("sabado");


