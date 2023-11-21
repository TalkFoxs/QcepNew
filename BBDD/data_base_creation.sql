drop database if exists qcep;
create database qcep character set utf8mb4 collate utf8mb4_spanish_ci;

use qcep;

-- process N : N Recurs
-- proces N : N punt de la norma
-- proces N : N sortida
-- proces N : N proveidor
create table proces (
	id int auto_increment,
	nom varchar(100) not null,
    tipus varchar(100) not null,
    objectiu varchar(300) not null,
    usuari_username varchar(100) not null,
    foreign key(usuari_username) references usuari(username)
);

create table document(
	id int auto_increment,
	nom varchar(100) not null,
    tipus varchar(100) not null,
    link varchar(200) not null,
    proces_nom varchar(100) not null,
    foreign key(proces_nom) references proces(nom)
);

create table usuari(
	username varchar(100) not null,
    email varchar(100) not null,
    es_administrador boolean not null
);

create table avaluacio(
	tipus varchar(100) not null,
    nivell varchar(100) not null,
    valoracio varchar(200) not null,
    planificacio varchar(100) not null,
    accions varchar(300) not null,
    estrategia varchar(100) not null
);

create table avaluacions(
	avaluacio_tipus varchar(200) primary key,
    usuari_username varchar(100) not null,
    proces_nom varchar(100) not null,
    foreign key(avaluacio_tipus) references avaluacio(tipus),
    foreign key(usuari_username) references usuari(username),
    foreign key(proces_nom) references proces(nom)
);

create table indicador(
	codi varchar(50) not null,
    nom varchar(100) not null,
    link varchar(200) not null,
    curs varchar(50) not null,
    valoracio varchar(100) not null,
    proces_nom varchar(100) not null,
	foreign key(proces_nom) references proces(nom)
);

create table organitzacio(
	nom varchar(50) not null,
>>>>>>> fe289f7 (base de dades)
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null
);

-- grupInteres 0,1 : 0,N Sortida
-- grupInteres 0,1 : 0,N proveidor
create table grupInteres(
	nom varchar(100) not null,
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

create table puntNorma(
	primerNum int not null,
    segundaNum int not null,
    primary key(primerNum,segundaNum)
);

create table proces_te_puntNorma(
	num1 int not null,
    num2 int not null,
    proces_nom varchar(100) not null,
    primary key (num1,num2,proces_id),
    foreign key (num1) references puntNorma(primerNum),
    foreign key (num2) references puntNorma(segundaNum),
    foreign key (proces_nom) references proces(nom)
);

create table recurs(
	nom varchar(100) not null,
    tipus varchar(300) not null
);

-- proces N : N recurs
create table necessita(
	recus_tipus varchar(100) not null,
    proces_id int not null,
    primary key (recurs_tipus,proces_id),
    foreign key (recurs_tipus) references recurs(tipus),
    foreign key (proces_id) references proces(id)
);