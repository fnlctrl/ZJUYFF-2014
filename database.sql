use film2014;

create table author(
	id int primary key,
	stuid1 bigint,
	name1 char(10),
	college1 char(30),
	contact1 char(30),
	stuid2 bigint,
	name2 char(10),
	college2 char(30),
	contact2 char(30),
	stuid3 bigint,
	name3 char(10),
	college3 char(30),
	contact3 char(30)
)DEFAULT CHARSET=utf8;

create table img(
	id int primary key,
	name char(50),
	intro text(500)
)DEFAULT CHARSET=utf8;

create table score(
	id int primary key,
	cx int,
	bz int,
	js int,
	ys int,
	cw int,
	num int
)DEFAULT CHARSET=utf8;

create table ip(
	ip int primary key
)DEFAULT CHARSET=utf8;