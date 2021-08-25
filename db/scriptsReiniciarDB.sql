DELETE FROM LOGS
--DELETE FROM REF_CODES
DELETE FROM CONSECUTIVOS
DELETE FROM SERVICIOS_PARTICULAR
DELETE FROM TOURS
DELETE FROM RESERVAS_TOUR
DELETE FROM RESERVAS
DELETE FROM VUELOS
DELETE FROM SERVICIOSXPROVEEDOR
DELETE FROM SERVICIOS_PAQUETES
DELETE FROM SERVICIOS
DELETE FROM UBICACIONES
DELETE FROM NACIONALIDADES
DELETE FROM PROVEEDORES
DELETE FROM USUARIOS
DELETE FROM CLIENTES
DELETE FROM CONTACTOS
DELETE FROM PAQUETES
--DELETE FROM OFICINAS
--DELETE FROM PERMISOSXROL
--DELETE FROM PERMISOS
--DELETE FROM ROLES


-- USUARIOS
INSERT INTO USUARIOS (CODUSR, CLAVE, CODROL, NOMBRE, APELLIDOS, FDIGITA, CODUSRDIG) VALUES ('admin', 'Domola8405*', 'ADM', 'Administrador', NULL, '2021-08-01', 'admin') 

-- NACIONALIDADES
INSERT INTO NACIONALIDADES (CODNAC, NACIONAL) VALUES ('COL', 'Colombia')

-- SERVICIOS
INSERT INTO SERVICIOS (CODSER, NOMSER, SELDEFECTO, ORDENSALE) VALUES ('IN', 'Transfer IN', 'SI', '1') 
INSERT INTO SERVICIOS (CODSER, NOMSER, SELDEFECTO, ORDENSALE) VALUES ('OUT', 'Transfer OUT', 'SI', '2')

-- CONSECUTIVOS
INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) VALUES('RES',1000,'OCU')
INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) VALUES('VOU ADZ',1000,'OCU')
INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) VALUES('VOU CTG',1000,'OCU')
INSERT INTO CONSECUTIVOS (TIPO, NUM, ESTADO) VALUES('VOU SMR',1000,'OCU')
