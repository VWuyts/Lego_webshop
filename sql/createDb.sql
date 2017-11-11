/*
	Lego Webshop
	
	Lab assignment for course PHP & MySQL 2017
	Thomas More campus De Nayer
	Bachelor Elektronica-ICT -- Application Development
	
	Véronique Wuyts
 */

 /* Create database */
 DROP DATABASE IF EXISTS legoshop;
 CREATE DATABASE legoshop;
 USE legoshop;

 /* Create table registeredUser */
 DROP TABLE IF EXISTS registeredUser; -- user is included in list of keywords and reserved words
 CREATE TABLE registeredUser (
	userID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	surname VARCHAR(50) NOT NULL,
	firstName VARCHAR(50) NOT NULL,
	role ENUM("admin", "customer") NOT NULL,
	email VARCHAR(255) NOT NULL,
	passw VARCHAR(64) NOT NULL, -- password is included in list of keywords and reserved words
	isActive BOOLEAN NOT NULL DEFAULT 1,
	PRIMARY KEY (userID),
	UNIQUE (email) -- email is used as login
 );
 
 /* Create table address */
 DROP TABLE IF EXISTS address;
 CREATE TABLE address (
	addressID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	street VARCHAR(50) NOT NULL,
	hNumber SMALLINT UNSIGNED NOT NULL, -- number is included in list of keywords and reserved words
	box VARCHAR(8),
	postalCode VARCHAR(8) NOT NULL,
	city VARCHAR(50) NOT NULL,
	country VARCHAR(50) NOT NULL,
	PRIMARY KEY (addressID)
 );
 
 /* Create table customerAddress */
 DROP TABLE IF EXISTS customerAddress;
 CREATE TABLE customerAddress (
	custAddressID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	userID INT UNSIGNED NOT NULL,
	addressID INT UNSIGNED NOT NULL,
	isInvoice BOOLEAN NOT NULL DEFAULT 1,
	isActive BOOLEAN NOT NULL DEFAULT 1,
	tao VARCHAR(100), -- tao == the attention of
	PRIMARY KEY (custAddressID),
	FOREIGN KEY (userID) REFERENCES registeredUser(userID),
	FOREIGN KEY (addressID) REFERENCES address(addressID)
 );
 
 /* Create table shippingCost */
 DROP TABLE IF EXISTS shippingCost;
 CREATE TABLE shippingCost (
	costID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	amount DECIMAL(5,2) NOT NULL,
	minPurchase DECIMAL(6,2) NOT NULL DEFAULT 0,
	country VARCHAR(50) NOT NULL DEFAULT "België",
	PRIMARY KEY (costID)
 );
 
 /* Create table orders */
 DROP TABLE IF EXISTS orders; -- order is included in list of keywords and reserved words
 CREATE TABLE orders (
	orderno INT UNSIGNED NOT NULL AUTO_INCREMENT,
	orderDate DATE NOT NULL,
	userID INT UNSIGNED NOT NULL,
	isPayed BOOLEAN NOT NULL DEFAULT 0,
	orderStatus ENUM("processing", "shipped", "delivered") NOT NULL, -- status is included in list of keywords and reserved words
	invoiceAddressID INT UNSIGNED NOT NULL,
	shipAddressID INT UNSIGNED NOT NULL,
	shipCostID INT UNSIGNED NOT NULL,
	PRIMARY KEY (orderno),
	FOREIGN KEY (userID) REFERENCES registeredUser(userID),
	FOREIGN KEY (invoiceAddressID) REFERENCES customerAddress(custAddressID),
	FOREIGN KEY (shipAddressID) REFERENCES customerAddress(custAddressID),
	FOREIGN KEY (shipCostID) REFERENCES shippingCost(costID)
 );
 
 /* Create table theme */
 DROP TABLE IF EXISTS theme;
 CREATE TABLE theme (
	themeID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	tName VARCHAR(50) NOT NULL,
	PRIMARY KEY (themeID),
	UNIQUE (tName)
 );
 
 /* Create table sort */
 DROP TABLE IF EXISTS sort;
 CREATE TABLE sort (
	sortID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	sName VARCHAR(50) NOT NULL,
	PRIMARY KEY (sortID),
	UNIQUE (sName)
 );
 
/* Create table label */
 DROP TABLE IF EXISTS label;
 CREATE TABLE label (
	labelID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	lName VARCHAR(50) NOT NULL,
	PRIMARY KEY (labelID),
	UNIQUE (lName)
 );
 
 /* Create table product */
 DROP TABLE IF EXISTS product;
 CREATE TABLE product (
     productno MEDIUMINT(5) UNSIGNED NOT NULL,
	 pName VARCHAR(50) NOT NULL,
	 price DECIMAL(6,2) UNSIGNED NOT NULL,
	 minAge TINYINT(2) UNSIGNED NOT NULL DEFAULT 4,
	 description TEXT NOT NULL,
	 isActive BOOLEAN NOT NULL DEFAULT 1,
	 category ENUM("sets", "extras") NOT NULL,
	 pieces SMALLINT UNSIGNED,
	 themeID INT UNSIGNED,
	 sortID INT UNSIGNED,
	 labelID INT UNSIGNED,
	 PRIMARY KEY (productno),
	 FOREIGN KEY (themeID) REFERENCES theme(themeID),
	 FOREIGN KEY (sortID) REFERENCES sort(sortID),
	 FOREIGN KEY (labelID) REFERENCES label(labelID),
	 UNIQUE (pName)
 );
 
/* Create table orderDetail */
 DROP TABLE IF EXISTS orderDetail;
 CREATE TABLE orderDetail (
	orderno INT UNSIGNED NOT NULL,
	productno MEDIUMINT(5) UNSIGNED NOT NULL,
	quantity TINYINT UNSIGNED NOT NULL DEFAULT 1,
	PRIMARY KEY (orderno, productno),
	FOREIGN KEY (orderno) REFERENCES orders(orderno),
	FOREIGN KEY (productno) REFERENCES product(productno)
 );