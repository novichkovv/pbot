CREATE DATABASE auto_db CHARACTER SET utf8;

USE auto_db;

CREATE TABLE prices (
  id SERIAL PRIMARY KEY,
  brand VARCHAR (255) NOT NULL,
  model VARCHAR (255) NOT NULL,
  production_year VARCHAR(10) NOT NULL,
  msrp INT NOT NULL,
  sale_price INT NOT NULL,
  savings INT NOT NULL,
  savings_pc DECIMAL(6,2) NOT NULL,
  upload_date DATE NOT NULL
);
