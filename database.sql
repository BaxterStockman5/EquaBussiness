-- Active: 1733300995830@@127.0.0.1@3306@phpmyadmin
-- Crear la base de datos
DROP DATABASE IF EXISTS EquaBussiness2;
CREATE DATABASE EquaBussiness2;
USE EquaBussiness2;

show tables;
-- tablas 
-- Crear la tabla categorias
CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

-- Crear la tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) not null,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla productos con clave foránea hacia categorias
CREATE TABLE IF NOT EXISTS productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    id_categoria INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    disponible INT NOT NULL CHECK (disponible >= 0),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE
);

-- Crear la tabla pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    codcliente INT,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL CHECK (total >= 0),
    estado ENUM('pendiente', 'procesado', 'entregado', 'cancelado') DEFAULT 'pendiente',
    FOREIGN KEY (codcliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE
);

-- Crear la tabla detalles_pedidos
CREATE TABLE IF NOT EXISTS detalles_pedidos (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    codcliente INT,
    id_producto INT,
    cantidad INT CHECK (cantidad > 0),
    precio_unitario DECIMAL(10,2) CHECK (precio_unitario >= 0),
    subtotal DECIMAL(10,2) CHECK (subtotal >= 0),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (codcliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);

-- Crear la tabla administradores
CREATE TABLE IF NOT EXISTS administradores (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    foto VARCHAR(255) DEFAULT 'default.jpg',
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

-- Crear la tabla carrito
CREATE TABLE IF NOT EXISTS carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    codcliente INT,
    codproducto INT NOT NULL,
    cantidad INT CHECK (cantidad > 0),
    FOREIGN KEY (codcliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (codproducto) REFERENCES productos(id_producto) ON DELETE CASCADE
);

-- Insertar registros de ejemplo en la tabla categorias
INSERT INTO categorias (nombre) VALUES 
('Electrónica'),
('Moda'),
('Hogar'),
('Otros'),
('Libros'),
('Deportes'),
('Juegos'),
('Cuidado de la Salud'),
('Alimentación'),
('Herramientas');


alter table pedidos add id_producto int;
alter table pedidos add foreign key (id_producto) references productos (id_producto);

-- drop database EquaBussiness;

show tables;
use EquaBussiness2;
select * from detalles_pedidos;
describe productos;

select distinct estado from pedidos;

describe pedidos;

show columns from pedidos like 'estado';

CREATE TABLE publicidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL
);



