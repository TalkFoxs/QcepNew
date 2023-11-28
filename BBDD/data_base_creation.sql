drop database if exists qcep;
create database qcep character set utf8mb4 collate utf8mb4_spanish_ci;

use qcep;

create table usuari(
	username varchar(100)primary key,
    password varchar(200) not null,
    email varchar(100) not null,
    es_administrador boolean not null
);

create table puntNorma(
	primerNum int not null,
    segundaNum int not null,
    primary key(primerNum,segundaNum)
);

create table proces (
	nom varchar(100) primary key,
    tipus varchar(100) not null,
    objectiu varchar(300) not null,
    usuari_username varchar(100) not null,
    foreign key(usuari_username) references usuari(username)
);

create table proces_te_puntNorma(
	num1 int not null,
    num2 int not null,
    proces_nom varchar(100) not null,
    primary key (num1,num2,proces_nom),
	foreign key(num1, num2) REFERENCES puntNorma(primerNum, segundaNum),
    foreign key (proces_nom) references proces(nom)
);

create table document(
	nom varchar(100) primary key,
    tipus varchar(100) not null,
    link varchar(200) not null,
    proces_nom varchar(100) not null,
    foreign key(proces_nom) references proces(nom)
);

create table avaluacio(
	tipus varchar(100) not null primary key,
    nivell varchar(100) not null,
    valoracio varchar(200) not null,
    planificacio varchar(100) not null,
    accions varchar(300) not null,
    estrategia varchar(100) not null
);

create table avaluacions(
	avaluacio_tipus varchar(200) not null primary key,
    usuari_username varchar(100) not null,
    proces_nom varchar(100) not null,
    foreign key(avaluacio_tipus) references avaluacio(tipus),
    foreign key(usuari_username) references usuari(username),
    foreign key(proces_nom) references proces(nom)
);

create table indicador(
	codi varchar(50) not null primary key,
    nom varchar(100) not null,
    link varchar(200) not null,
    curs varchar(50) not null,
    valoracio varchar(100) not null,
    proces_nom varchar(100) not null,
	foreign key(proces_nom) references proces(nom)
);

create table organitzacio(
	nom varchar(50) not null primary key,
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null
);

create table grupInteres(
	nom varchar(100) not null primary key,
    descripcio varchar(300) not null
);

create table proveidor(
	grup_nom varchar(100) not null,
    proces_nom varchar(100) not null,
    entrada varchar(300) not null,
    primary key(grup_nom,proces_nom),
    foreign key(grup_nom) references grupInteres(nom),
    foreign key(proces_nom) references proces(nom)
);

create table client(
	grup_nom varchar(100) not null,
    proces_nom varchar(100) not null,
    sortida varchar(300) not null,
    primary key(grup_nom,proces_nom),
    foreign key(grup_nom) references grupInteres(nom),
    foreign key(proces_nom) references proces(nom)
);

create table recurs(
	nom varchar(100) not null primary key,
    tipus varchar(300) not null
);

create table proces_necessita_recurs(
	recurs_nom varchar(100) not null,
    proces_nom varchar(100) not null,
    primary key (recurs_nom,proces_nom),
    foreign key (recurs_nom) references recurs(nom),
    foreign key (proces_nom) references proces(nom)
);

create table apartat(
	nom varchar(100) not null primary key,
    icona varchar(100) not null,
    descripcio varchar(200) not null,
    link varchar(100) not null
);