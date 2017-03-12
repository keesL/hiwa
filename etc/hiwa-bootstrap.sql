begin transaction;
INSERT INTO users 
(login, password, role)
VALUES ('flag', '57d9d59e04584a980337376235d6d2b4', 'user');

INSERT INTO users 
(login, password, role)
VALUES ('admin', 'admin', 'admin');

INSERT INTO products
(productid, productname, productdescr, msrp, imageurl)
VALUES
('mug001', 'XSS Mug', 'A mug with XSS print', 14.99, NULL);

INSERT INTO products
(productid, productname, productdescr, msrp, imageurl)
VALUES
('shirt001', 'SQLi Shirt XL', 'XL T-shirt with SQLi print', 34.99, NULL);

INSERT INTO customers
(customerid, customername, creditlimit, taxid)
VALUES
('cust001', 'Smith Retail Co', 1000, '123456789');

INSERT INTO customers
(customerid, customername, creditlimit, taxid)
VALUES
('cust002', 'Geeks-R-us', 0, '987654321');

INSERT INTO customers
(customerid, customername, creditlimit, taxid)
VALUES
('cust003', 'Flag and stuff', 0, '5d01d800df41f6b');

INSERT INTO orders
(orderid, customerid, status)
VALUES
('201700001', 'cust002', 'prepared');

INSERT INTO lineitems
(orderid, productid, numprods, prodprice)
VALUES
('201700001', 'mug001', 5, 12.50);

INSERT INTO lineitems
(orderid, productid, numprods, prodprice)
VALUES
('201700001', 'shirt001', 10, 24.95);
commit;
