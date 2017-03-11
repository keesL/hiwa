begin transaction;
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

INSERT INTO orders
(orderid, customerid, productid, numprods, prodprice)
VALUES
('201700001', 'cust002', 'mug001', 10, 11.95);

INSERT INTO orders
(orderid, customerid, productid, numprods, prodprice)
VALUES
('201700001', 'cust002', 'shirt001', 10, 24.95);
commit;
