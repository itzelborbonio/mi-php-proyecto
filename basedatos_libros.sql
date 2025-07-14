CREATE DATABASE IF NOT EXISTS tienda_libros;
USE tienda_libros;
CREATE TABLE usuarios (id_usuario INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100), correo VARCHAR(100) UNIQUE, contraseña VARCHAR(255), direccion TEXT, telefono VARCHAR(20), fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE categorias (id_categoria INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(50));
CREATE TABLE libros (id_libro INT AUTO_INCREMENT PRIMARY KEY, titulo VARCHAR(200), autor VARCHAR(150), editorial VARCHAR(150), descripcion TEXT, precio DECIMAL(10,2), imagen VARCHAR(255), categoria_id INT, FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria));
CREATE TABLE pedidos (id_pedido INT AUTO_INCREMENT PRIMARY KEY, id_usuario INT, fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario));
CREATE TABLE detalle_pedido (id_detalle INT AUTO_INCREMENT PRIMARY KEY, id_pedido INT, id_libro INT, cantidad INT, subtotal DECIMAL(10,2), FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido), FOREIGN KEY (id_libro) REFERENCES libros(id_libro));