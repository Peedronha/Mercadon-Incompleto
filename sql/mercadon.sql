create database mercadon;

SHOW ENGINE INNODB STATUS;
CREATE TABLE Category(
    CategoryID int NOT NULL PRIMARY KEY auto_increment,
    CategoryName varchar(65) NOT NULL,
    created_at timestamp,
    modified_at timestamp null
);

CREATE TABLE Product (
    ProductID int NOT NULL PRIMARY KEY auto_increment,
    ProductName varchar(55) NOT NULL,
    ProductDesc varchar(5500), 
	ProductPrice Decimal(9,3),
	ProductSalePrice Decimal(9,3),
	ProductStock int,
	ProductCategory int,
    created_at timestamp,
    modified_at timestamp null,
    CONSTRAINT FK_ProductCategory FOREIGN KEY (ProductCategory)
    REFERENCES Category(CategoryID)
);

/*CREATE TABLE Postal (
    PostalCode int NOT NULL PRIMARY KEY,
	PostalArea varchar(55) NOT NULL,
    created_at timestamp,
	modified_at timestamp null
);


CREATE TABLE City (
    CityId int NOT NULL PRIMARY KEY auto_increment,
	CityName varchar(55) NOT NULL,
    created_at timestamp,
    modified_at timestamp null
);*/

CREATE TABLE Customer (
    CustomerID int NOT NULL PRIMARY KEY auto_increment,
    CustomerName varchar(55) NOT NULL,
    CustomerEmail varchar(55),
	CustomerPassword varchar(55),
	/*CustomerAddress varchar(55),
    CustomerCity int,
    CustomerPostalCode int,*/
    verification_code int,
    aut tinyint,
    active tinyint,
    created_at timestamp,
    modified_at timestamp null
    /*constraint FK_CustomerCity foreign key (CustomerCity) references city(cityId) ON DELETE CASCADE ON UPDATE CASCADE,
	constraint FK_CustomerPostalCode foreign key (CustomerPostalCode) references postal(PostalCode) ON DELETE CASCADE ON UPDATE CASCADE*/
);

CREATE TABLE OrderTable (
    OrderID int NOT NULL PRIMARY KEY auto_increment,
	OrderNumber int,
    OrderDate DATE,
	OrderTotal Decimal(9,3),
	ShippingDate DATE,
    CustomerID int,
	is_delivered varchar(6),
    created_at timestamp,
    modified_at timestamp null,
    constraint FK_CustomerID foreign key (CustomerID) REFERENCES Customer(CustomerID)
);

CREATE TABLE OrderDetail (
    OrderDetailID int NOT NULL PRIMARY KEY auto_increment,
    ProductID int,
	ProductQty int,
	ProductPrice Decimal(9,3),
    OrderID int,
    created_at timestamp,
     modified_at timestamp null,
	SubTotal Decimal(9,3),
	constraint FK_ProductID foreign key (ProductID) REFERENCES Product(ProductID),
    constraint FK_OrderID foreign key (OrderID) REFERENCES OrderTable(OrderID)
);
SELECT * FROM customer;
INSERT INTO `mercadon`.`product`
(`ProductID`,
`ProductName`,
`ProductDesc`,
`ProductPrice`,
`ProductSalePrice`,
`ProductStock`,
`ProductCategory`,
`ProductImage`,
`created_at`)
VALUES
('Alface',
2.0,
"",
5,
8,
1,
'',
current_timestamp()
);

INSERT INTO customer (CustomerName, CustomerEmail, CustomerPassword,  verification_code, aut, active,acess_level, created_at) VALUES ('aaa', '$email', 123, '$verification_code', 0, 0, 0, '$date');