create database CFDB;
use CFDB;
create table usuario(
	idUsuario int(11) not null auto_increment primary key,
	nomeUsuario varchar(100) not null,
	nickUsuario varchar(40) not null unique,
	emailUsuario varchar(150) not null unique,
	senhaUsuario varchar(32) not null,
	dataCad datetime default current_timestamp,
	dataAlt datetime default current_timestamp
);
create table dadosUsuario(
	codDadosU int(11) not null  auto_increment primary key,
	idUsuarioFk int(11) not null unique,
	cpfUsuario int(11) not null unique,
	rgUsuario int(9) not null unique,
	rank int(3) not null,
	foreign key (idUsuarioFk) references usuario (idUsuario)
);
create table agendamento(
	codAgend int(11) not null auto_increment primary key,
	descAgend text null default null,
	idUsuarioFk int(11) not null,
	dataAgend datetime default current_timestamp,
	dataTreino datetime,
	foreign key (idUsuarioFk) references usuario (idUsuario)
);
create table dataAgend(
	codData INT(11) NOT NULL AUTO_INCREMENT primary key,
	dataDispo INT(11) NULL DEFAULT NULL
	);
