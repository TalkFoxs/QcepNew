drop database if exists qcep;
create database qcep character set utf8mb4 collate utf8mb4_spanish_ci;

use qcep;

<<<<<<< HEAD
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
=======
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

create table usuari(
	id int primary key auto_increment,
	username varchar(50) not null,
    email varchar(100) not null,
    es_administrador char(2) not null
);

create table avaluacio(
	id int primary key auto_increment,
	tipus varchar(10) not null,
    nivell varchar(100) not null,
    valoracio varchar(50) not null,
    planificacio varchar(50) not null,
    accions varchar(50) not null,
    estrategia varchar(100) not null
);

-- proces 1 : N avaluacio : 1 usuari OK
create table responsable(
	avaluacio_id int primary key,
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
>>>>>>> fe289f7 (base de dades)
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null
);

<<<<<<< HEAD
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
=======
-- grupInteres 0,1 : 0,N Sortida
-- grupInteres 0,1 : 0,N proveidor
create table grupInteres(
	id int primary key auto_increment,
	nom varchar(50) not null,
    descripcio varchar(300) not null
);

-- proveidor/client: qui dona dada al proces
-- nom i clau
create table proveidor_client(
	nom varchar(50) not null,
    clau varchar(50) not null
);

-- grupInteres 0,1 : 0,N proveidor/client
create table grup_te_proveidor(
	grup_id int not null,
    nom varchar(50) not null,
    primary key (grup_id,nom),
    foreign key (grup_id) references grupInteres(id),
    foreign key (nom) references proveidor_client(nom)
);

-- proces N : N proveidor/client
create table proces_proveidor_client(
	nom varchar(50) not null,
    proces_id int not null,
    primary key (nom, proces_id),
    foreign key (nom) references proveidor_client(nom),
    foreign key (proces_id) references proces(id)
);

-- punt de la norma
-- primerNum i segundaNum
create table puntNorma(
	primerNum int not null,
    segundaNum int not null
);

-- proces N : N puntNorma
create table puntNorma_proces(
	num1 int not null,
    num2 int not null,
    proces_id int not null,
    primary key (num1,num2,proces_id),
    foreign key (num1) references puntNorma(primerNum),
    foreign key (num2) references puntNorma(segundaNum),
    foreign key (proces_id) references proces(id)
);

-- recurs
-- tipus i descripció
create table recurs(
	tipus varchar(100) not null,
    descripcio varchar(300) not null
);

-- proces N : N recurs
create table necessita(
	recus_tipus varchar(100) not null,
    proces_id int not null,
    primary key (recurs_tipus,proces_id),
    foreign key (recurs_tipus) references recurs(tipus),
    foreign key (proces_id) references proces(id)
>>>>>>> fe289f7 (base de dades)
);