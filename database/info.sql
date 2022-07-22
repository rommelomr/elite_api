insert into terminals (name) values ('Terminal 1'),('Terminal 2'),('Terminal 3'),('Terminal 4');

insert into identification_types (name) values ('NIF'), ('NIE'), ('Pasaporte');

insert into services (name, price) values ('Lavado exterior',10), ('Lavado interior',15), ('Lavado interior + exterior', 23);

insert into payment_methods (name) values ('TPV en la recogida'),('TPV en la devolución'), ('Efectivo en la recogida'), ('Efectivo en la devolución');

INSERT INTO users (role,username,email,email_verified_at,password) VALUES ('A','Administrador','admin@admin.com','2020-11-26 23:23:37','$2y$10$Kd/MKx6dCo//MSPaFls9PO2iRFKGM9I6n8S6l.mcvFTYaIuf2fdwG');

insert into prices (days,price) values 
	(1,18.98),
	(2,23.00),
	(3,27.00),
	(4,32.98),
	(5,40.00),
	(6,45.00),
	(7,50.00),
	(8,56.00),
	(9,60.00),
	(10,65.00),
	(11,70.00),
	(12,70.00),
	(13,70.00),
	(14,70.00),
	(15,76.00),
	(16,76.00),
	(17,76.00),
	(18,76.00),
	(19,76.00),
	(20,80.00),
	(21,82.50),
	(22,82.50),
	(23,82.50),
	(24,82.50),
	(25,82.50),
	(26,82.50),
	(27,90.00),
	(28,95.00),
	(29,99.00),
	(30,99.00),
	(31,99.00),
	(32,99.00);





INSERT INTO users (username,email,email_verified_at,password) VALUES ('portillo','portillo@gmail.com','2020-11-26 23:23:37','$2y$10$Kd/MKx6dCo//MSPaFls9PO2iRFKGM9I6n8S6l.mcvFTYaIuf2fdwG');

INSERT INTO persons VALUES (1,'Rommel Montoya',1,25594817,'04144666342','rommelmontoya97@gmail.com','2020-11-26 23:23:37','2020-11-26 23:23:37');
INSERT INTO clients VALUES (1,1,'2020-11-26 23:23:37','2020-11-26 23:23:37');
INSERT INTO brands VALUES (1,'Renault','2020-11-26 23:23:37','2020-11-26 23:23:37');
INSERT INTO models VALUES (1,'Logan','2020-11-26 23:23:37','2020-11-26 23:23:37');
INSERT INTO vehicles VALUES (1,'GBJ63L',1,1,'Negro','2020-11-26 23:23:37','2020-11-26 23:23:37');


insert into reservations (price,client_id,vehicle_id,receiver_car_driver_id,devolution_car_driver_id,payment_method_id,city,reception_terminal_id,devolution_terminal_id,reception_date, reception_time,devolution_date, devolution_time,has_luggage,flight_number,invoice_required,observation,status)
values
(30,1,1,null,null,null,'Caracas',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,1,0,'Ninguna',0)
,(30,1,1,null,null,null,'Valencia',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,2,0,'Ninguna',0)
,(30,1,1,null,null,null,'Barinas',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,3,0,'Ninguna',0)
,(30,1,1,null,null,null,'Trujillo',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,4,0,'Ninguna',0)
,(30,1,1,null,null,null,'Nueva Esparta',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,5,0,'Ninguna',0)
,(30,1,1,null,null,null,'Maracaibo',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Falcon',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Lara',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'El junquito',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Los palos grandes',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Plaza venezuela',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Chacao',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Chacaito',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Avenida Sucre',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Mansion Foster',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Springfild',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Sodoma',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Gomorrra',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Jerusalen',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Arabia',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Ureña',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Aguas calientes',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Puerto ayacucho',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Puerto Rico',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Cuba',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'Corea del sur',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,6,0,'Ninguna',0)
,(30,1,1,null,null,null,'San Antonio',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,7,0,'Ninguna',0)
,(30,1,1,null,null,null,'Monagas',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,8,0,'Ninguna',0)
,(30,1,1,null,null,null,'Anzoategui',2,4,'2020-01.01', '01:00','2020-02-01', '02:00',1,9,0,'Ninguna',0);


alter table payment_methods auto_increment = 5;
insert into payment_methods(name) values ('TPV virtual');
	