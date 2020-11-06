#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username hiwa --dbname hiwa <<-EOSQL
begin transaction;
-- the users table
-- contains details for people allowed to use the web application
CREATE TABLE users (
	login	  varchar(25),
	password  varchar(40),
	role      varchar(10),
	primary key (login),
	check (role in ('admin', 'manager', 'user'))
);

-- the product catalog
CREATE TABLE products (
	productid	varchar(10),
	productname	varchar(30),
	productdescr	varchar(255),
	msrp		numeric(5,2),
	imageurl	varchar(255),
	primary key (productid)
);

-- customers
CREATE TABLE customers (
	customerid	varchar(10),
	customername	varchar(100),
	creditlimit	numeric(6,2),
	taxid		varchar(15),
	primary key (customerid)
);

CREATE TABLE orders (
	orderid		varchar(10),
	customerid	varchar(10),
	status		varchar(10),
	check (status in ('new', 'prepared', 'shipped', 'billed', 'paid')),
	foreign key (customerid) references customers,
	primary key (orderid)
);

CREATE TABLE lineitems (
	orderid		varchar(10),
	productid	varchar(10),
	numprods	numeric(3,0),
	prodprice	numeric(5,2),
	foreign key (productid) references products,
	foreign key (orderid) references orders
);
commit;
EOSQL
