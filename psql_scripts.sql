CREATE TABLE IF NOT EXISTS users (id BIGSERIAL PRIMARY KEY, login VARCHAR, password VARCHAR);
CREATE TABLE IF NOT EXISTS vendors (vendor_name VARCHAR, vendor_shortName VARCHAR, vendor_region VARCHAR, vendor_id BIGSERIAL PRIMARY KEY);
CREATE TABLE IF NOT EXISTS products (vendor_id BIGINT REFERENCES vendors(vendor_id), product_name VARCHAR, product_seamType VARCHAR, product_subType VARCHAR, product_document VARCHAR, product_diameterMin DOUBLE PRECISION, product_diameterMax DOUBLE PRECISION, product_width DOUBLE PRECISION, product_height DOUBLE PRECISION, product_thicknessMin DOUBLE PRECISION, product_thicknessMax DOUBLE PRECISION, product_steelMark VARCHAR, product_price DOUBLE PRECISION, product_status VARCHAR, product_id BIGSERIAL PRIMARY KEY);

CREATE TABLE IF NOT EXISTS GOST_info (
  id serial NOT NULL PRIMARY KEY,
  name VARCHAR(160)
  );

CREATE TABLE IF NOT EXISTS DIAMETER_info (
  id serial NOT NULL PRIMARY KEY,
  value double precision);

CREATE TABLE IF NOT EXISTS STEEL_GRADE_info (
  id serial NOT NULL PRIMARY KEY,
  name VARCHAR(100) NOT null);
 
CREATE TABLE IF NOT EXISTS WALL_THICKNESS_info (
  id serial not NULL PRIMARY KEY,
  value double precision);

CREATE TABLE IF NOT EXISTS MAIN_TABLE (
id serial not null PRIMARY KEY,
chamfer boolean DEFAULT false,
DIAMETER_info_id int references DIAMETER_info(ID),
GOST_info_id int references GOST_info(ID),
STEEL_GRADE_info_id int references STEEL_GRADE_info(ID),
WALL_THICKNESS_info_id int references WALL_THICKNESS_info(ID));

CREATE TABLE IF NOT EXISTS MECH_PROP_info (
  id serial NOT NULL PRIMARY KEY,
  name VARCHAR(100));

CREATE TABLE IF NOT EXISTS TESTS_info (
  id serial PRIMARY KEY,
  name VARCHAR(100));

CREATE TABLE IF NOT EXISTS MECH_PROP_USE (
  id serial NOT NULL PRIMARY KEY,
  note double precision,
  MAIN_TABLE_id INT NOT null references MAIN_TABLE(ID),
  MECH_PROP_info_id INT references MECH_PROP_info(ID));
  
CREATE TABLE IF NOT EXISTS TESTS_USE (
  id serial NOT NULL PRIMARY KEY,
  t double precision,
  TESTS_info_id INT references TESTS_info(ID),
  MAIN_TABLE_id INT NOT null references MAIN_TABLE(ID),
  note double precision );
 
 CREATE TABLE IF NOT EXISTS MECH_PROP_TOL_info (
  id serial NOT null PRIMARY KEY,
  min double precision ,
  MECH_PROP_info_id INT NOT null references MECH_PROP_info(ID),
  STEEL_GRADE_info_id INT NOT null references STEEL_GRADE_info(ID));
 --------------------------------------------------------------------------------------
--START TRANSACTION;
INSERT INTO GOST_info (name) 
VALUES 
('ГОСТ 8731/32'),
('ГОСТ 10705'),
('ГОСТ 20295'),
('ГОСТ 8733/34');

--COMMIT;

--START TRANSACTION;
INSERT INTO DIAMETER_info (value) VALUES (219);
INSERT INTO DIAMETER_info (value) VALUES (426);
INSERT INTO DIAMETER_info (value) VALUES (76);
INSERT INTO DIAMETER_info (value) VALUES (114);

--COMMIT;

START TRANSACTION;
INSERT INTO STEEL_GRADE_info (name) VALUES ('09Г2С');
INSERT INTO STEEL_GRADE_info (name) VALUES ('10');
INSERT INTO STEEL_GRADE_info (name) VALUES ('20');
INSERT INTO STEEL_GRADE_info (name) VALUES ('35');
INSERT INTO STEEL_GRADE_info (name) VALUES ('45');

COMMIT;

--START TRANSACTION;
INSERT INTO WALL_THICKNESS_info (value) VALUES (10);
INSERT INTO WALL_THICKNESS_info (value) VALUES (12);
INSERT INTO WALL_THICKNESS_info (value) VALUES (14);
INSERT INTO WALL_THICKNESS_info (value) VALUES (16);
INSERT INTO WALL_THICKNESS_info (value) VALUES (3.2);

--COMMIT;

--START TRANSACTION;
INSERT INTO MECH_PROP_info (name) VALUES ('Относительное удлинение');
INSERT INTO MECH_PROP_info (name) VALUES ('Временное сопротивление');
INSERT INTO MECH_PROP_info (name) VALUES ('Предел текучести');

--COMMIT;


INSERT INTO TESTS_info (name) VALUES 
('Ударный изгиб'),
('Раздача'),
('Сплющивание'),
('Загиб');



--START TRANSACTION;
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (24, 1, 2);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (353, 2, 2);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (216, 3, 2);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (21, 1, 3);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (412, 2, 3);
INSERT into MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (245, 3, 3);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (17, 1, 4);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (510, 2, 4);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (294, 3, 4);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (14, 1, 5);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (588, 2, 5);
INSERT INTO MECH_PROP_TOL_info (min, MECH_PROP_info_id, STEEL_GRADE_info_id) VALUES (323, 3, 5);

--COMMIT;