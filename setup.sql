CREATE TABLE IF NOT EXISTS Users(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(64) UNIQUE, passw TEXT, regdate DATE, access INT, birthday DATE, phone VARCHAR(16), zip VARCHAR(16), sec VARCHAR(16) UNIQUE, address1 VARCHAR(64), city VARCHAR(64), country VARCHAR(32), first_name VARCHAR(32), last_name VARCHAR(32));

CREATE TABLE IF NOT EXISTS Categories(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(32) UNIQUE NOT NULL, img_path TEXT);

CREATE TABLE IF NOT EXISTS Products(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name TEXT, quantity INT UNSIGNED, description TEXT, avg_grade FLOAT, category_ID INT UNSIGNED, price DECIMAL(10,2), vat DECIMAL(10,2), preview INT UNSIGNED, added DATE, current_price DECIMAL(10,2),
FOREIGN KEY (category_ID) REFERENCES Categories(ID) ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS Orders(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_ID INT UNSIGNED,
payment_option VARCHAR(16), payment_received DECIMAL(10,2), order_placed TIMESTAMP, discount DECIMAL(10,2),
FOREIGN KEY (user_ID) REFERENCES Users(ID) ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS OrderItems(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, order_ID INT UNSIGNED,
item INT UNSIGNED, quantity INT UNSIGNED,  price DECIMAL (10,2), vat DECIMAL(10,2), shipped DATE, 
FOREIGN KEY (order_ID) REFERENCES Orders(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (item) REFERENCES Products(ID)  ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS OrderAddresses(ID INT UNSIGNED, addr_type CHAR NOT NULL, email VARCHAR(64), first_name VARCHAR(32), last_name VARCHAR(32),
phone VARCHAR(16), zip VARCHAR(16), address1 VARCHAR(64), city VARCHAR(64), country VARCHAR(32),
FOREIGN KEY (ID) REFERENCES Orders(ID) ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (ID, addr_type));

CREATE TABLE IF NOT EXISTS Images(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
product_ID INT UNSIGNED, path TEXT NOT NULL,
FOREIGN KEY (product_ID) REFERENCES Products(ID) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS Cart(user_ID INT UNSIGNED, item INT UNSIGNED,
quantity INT UNSIGNED, 
FOREIGN KEY (user_ID) REFERENCES Users(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (item) REFERENCES Products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (user_ID, item));

CREATE TABLE IF NOT EXISTS Comments(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(64), description VARCHAR(512), parent INT UNSIGNED, product_ID INT UNSIGNED, user_ID INT UNSIGNED, approved BOOLEAN,
FOREIGN KEY (parent) REFERENCES Comments(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (user_ID) REFERENCES Users(ID) ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (product_ID) REFERENCES Products(ID) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS Grades(user_ID INT UNSIGNED NOT NULL, product_ID INT UNSIGNED NOT NULL,
comment_ID INT UNSIGNED, grade INTEGER UNSIGNED NOT NULL,  
FOREIGN KEY (product_ID) REFERENCES Products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (user_ID) REFERENCES Users(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (comment_ID) REFERENCES Comments(ID) ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (user_ID, product_ID));

CREATE TABLE IF NOT EXISTS TagDefinitions(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
definition TEXT, title VARCHAR(64) UNIQUE NOT NULL);

CREATE TABLE IF NOT EXISTS Tags(ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
product_ID INT UNSIGNED, definition_ID INT UNSIGNED,
FOREIGN KEY (product_ID) REFERENCES Products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (definition_ID) REFERENCES TagDefinitions(ID) ON DELETE CASCADE ON UPDATE CASCADE);

ALTER TABLE Products ADD FOREIGN KEY (preview) REFERENCES Images(ID) ON DELETE SET NULL ON UPDATE CASCADE;
