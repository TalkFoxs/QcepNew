drop database if exists qcep;
create database qcep character set utf8mb4 collate utf8mb4_spanish_ci;

use qcep;

-- process N : N Recurs
-- proces N : N punt de la norma
-- proces N : N sortida
-- proces N : N proveidor
create table proces (
	id int primary key auto_increment,
    usuari_username varchar(50) not null,
	nom varchar(50) not null,
    tipus varchar(10) not null,
    responsable varchar(100) not null,
    descripcio varchar(300) not null,
    foreign key(usuari_username) references usuari(username)
);

-- process 1 : N document OK
create table document(
	id int primary key auto_increment,
    proces_id int not null,
	nom varchar(50) not null,
    tipus varchar(10) not null,
    link varchar(200) not null,
    foreign key(proces_id) references proces(id)
);

-- grupInteres 0,1 : 0,N Sortida
-- grupInteres 0,1 : 0,N proveidor
create table grupInteres(
	id int primary key auto_increment,
	nom varchar(50) not null,
    descripcio varchar(300) not null
);

create table usuari(
	id int primary key auto_increment,
	username varchar(50) not null,
    email varchar(100) not null,
    es_administrador char(2) not null
);

create table avaluacio(
	id int primary key auto_increment,
    proces_id int not null,
	tipus varchar(10) not null,
    nivell varchar(100) not null,
    valoracio varchar(50) not null,
    planificacio varchar(50) not null,
    accions varchar(50) not null,
    estrategia varchar(100) not null,
    foreign key(proces_id) references proces(id)
);

-- proces 1 : N avaluacio : 1 usuari OK
create table usuari_proces_avaluacio(
	avaluacio_id int primary key auto_increment,
    usuari_id int not null,
    proces_id int not null,
    foreign key(avaluacio_id) references avaluacio(id),
    foreign key(usuari_id) references usuari(id),
    foreign key(proces_id) references proces(id)
);

-- proces 1 : N indicador relacio(curs) OK
create table indicador(
	id int primary key auto_increment,
    proces_id int not null,
    curs char(10) not null,
	codi varchar(50) not null,
    nom varchar(50) not null,
    link varchar(200) not null,
    foreign key(proces_id) references proces(id)
);

create table organitzacio(
	id int primary key auto_increment,
	nom varchar(50) not null,
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null
);