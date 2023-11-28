drop database if exists qcep;
create database qcep character set utf8mb4 collate utf8mb4_spanish_ci;

use qcep;

<<<<<<< HEAD
<<<<<<< HEAD
-- process N : N Recurs
-- proces N : N punt de la norma
-- proces N : N sortida
-- proces N : N proveidor
=======
create table usuari(
	username varchar(100)primary key,
    email varchar(100) not null,
    es_administrador boolean not null
);

create table puntNorma(
	primerNum int not null,
=======
-- 先创建没有外键依赖的表
create table usuari(
    username varchar(100) not null,
    email varchar(100) not null,
    es_administrador boolean not null,
    primary key (username)
);

create table organitzacio(
    nom varchar(50) not null,
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null,
    primary key (nom)
);

create table grupInteres(
    nom varchar(100) not null,
    descripcio varchar(300) not null,
    primary key (nom)
);

create table puntNorma(
    primerNum int not null,
>>>>>>> 9b3d7de (Corregir errores)
    segundaNum int not null,
    primary key(primerNum,segundaNum)
);

<<<<<<< HEAD
>>>>>>> c6cd8c9 (fet, fin, crear les taules de base de dates)
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
=======
create table recurs(
    nom varchar(100) not null,
    tipus varchar(300) not null,
    primary key (nom)
);

create table avaluacio(
    tipus varchar(100) not null,
>>>>>>> 9b3d7de (Corregir errores)
    nivell varchar(100) not null,
    valoracio varchar(200) not null,
    planificacio varchar(100) not null,
    accions varchar(300) not null,
    estrategia varchar(100) not null,
    primary key (tipus)
);

-- 然后创建有外键依赖的表
create table proces (
    id int auto_increment,
    nom varchar(100) not null,
    tipus varchar(100) not null,
    objectiu varchar(300) not null,
    usuari_username varchar(100) not null,
    primary key (id),
    foreign key(usuari_username) references usuari(username)
);

create table document(
    id int auto_increment,
    nom varchar(100) not null,
    tipus varchar(100) not null,
    link varchar(200) not null,
    proces_nom varchar(100) not null,
    primary key (id),
    foreign key(proces_nom) references proces(nom)
);

create table avaluacions(
<<<<<<< HEAD
	avaluacio_tipus varchar(200) not null primary key,
=======
    avaluacio_tipus varchar(100) not null,
>>>>>>> 9b3d7de (Corregir errores)
    usuari_username varchar(100) not null,
    proces_nom varchar(100) not null,
    primary key(avaluacio_tipus, usuari_username, proces_nom),
    foreign key(avaluacio_tipus) references avaluacio(tipus),
    foreign key(usuari_username) references usuari(username),
    foreign key(proces_nom) references proces(nom)
);

create table indicador(
<<<<<<< HEAD
	codi varchar(50) not null primary key,
=======
    codi varchar(50) not null,
>>>>>>> 9b3d7de (Corregir errores)
    nom varchar(100) not null,
    link varchar(200) not null,
    curs varchar(50) not null,
    valoracio varchar(100) not null,
    proces_nom varchar(100) not null,
<<<<<<< HEAD
	foreign key(proces_nom) references proces(nom)
);

create table organitzacio(
<<<<<<< HEAD
	nom varchar(50) not null,
>>>>>>> fe289f7 (base de dades)
=======
	nom varchar(50) not null primary key,
>>>>>>> c6cd8c9 (fet, fin, crear les taules de base de dates)
    email varchar(100) not null,
    web varchar(100) not null,
    logo varchar(100) not null
);

-- grupInteres 0,1 : 0,N Sortida
-- grupInteres 0,1 : 0,N proveidor
create table grupInteres(
	nom varchar(100) not null primary key,
    descripcio varchar(300) not null
=======
    primary key (codi),
    foreign key(proces_nom) references proces(nom)
>>>>>>> 9b3d7de (Corregir errores)
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

<<<<<<< HEAD
-- proces N : N recurs
create table necessita(
	recus_tipus varchar(100) not null,
    proces_id int not null,
    primary key (recurs_tipus,proces_id),
    foreign key (recurs_tipus) references recurs(tipus),
    foreign key (proces_id) references proces(id)
=======
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
<<<<<<< HEAD
>>>>>>> c6cd8c9 (fet, fin, crear les taules de base de dates)
);
=======
);
>>>>>>> 9b3d7de (Corregir errores)
