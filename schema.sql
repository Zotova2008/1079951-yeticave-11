CREATE DATABASE yeti
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeti;

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR (250) UNIQUE NOT NULL,
  symbol_cat VARCHAR (100) UNIQUE NOT NULL
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lot_title VARCHAR(250) NOT NULL,
  lot_descript TEXT,
  lot_img VARCHAR(250),
  lot_price INT UNSIGNED NOT NULL,
  lot_step INT UNSIGNED,
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  date_final TIMESTAMP,
  id_category INT UNSIGNED NOT NULL,
  id_user INT UNSIGNED NOT NULL,
  id_user_winner INT UNSIGNED
);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT UNSIGNED NOT NULL,
  id_lot INT UNSIGNED NOT NULL,
  bet_sum INT UNSIGNED,
  bet_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_data (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_name VARCHAR(128) UNIQUE NOT NULL,
  user_password CHAR(64) NOT NULL,
  user_email VARCHAR(128) UNIQUE NOT NULL,
  user_contact TEXT NOT NULL,
  date_registr TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE UNIQUE INDEX user_name ON user_data(user_name);
CREATE UNIQUE INDEX user_email ON user_data(user_email);
CREATE UNIQUE INDEX symbol_cat ON category(symbol_cat);
CREATE UNIQUE INDEX category ON category(category_name);
CREATE INDEX lot_title ON lot(lot_title);

CREATE FULLTEXT INDEX lot_td_search ON lot(lot_title, lot_descript);
CREATE FULLTEXT INDEX lot_t_search ON lot(lot_title);
CREATE FULLTEXT INDEX lot_d_search ON lot(lot_descript);
