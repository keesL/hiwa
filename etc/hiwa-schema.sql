begin transaction;
-- the users table
-- contains details for people allowed to use the web application
CREATE TABLE users (
	login	  varchar(25),
	password  varchar(40),
	role      varchar(10),
	primary key (login),
	check (role in ('admin', 'user'))
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
	productid	varchar(10),
	numprods	numeric(3,0),
	prodprice	numeric(5,2),
	primary key (orderid, productid),
	foreign key (customerid) references customers,
	foreign key (productid) references products
);
commit;
