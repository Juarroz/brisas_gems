-- ==================================
-- CREACIÓN DE BASE DE DATOS Y TABLAS (VERSIÓN CORREGIDA)
-- ==================================

DROP DATABASE IF EXISTS brisas_gems;
CREATE DATABASE brisas_gems;
USE brisas_gems;

-- =============================
-- 1. SISTEMA Y USUARIOS
-- =============================

CREATE TABLE tipo_de_documento(
	tipdoc_id 		INT PRIMARY KEY AUTO_INCREMENT,
	tipdoc_nombre 	VARCHAR(100) NOT NULL
);

CREATE TABLE rol(
	rol_id 		INT PRIMARY KEY AUTO_INCREMENT,
	rol_nombre 	VARCHAR(50) NOT NULL
);

CREATE TABLE usuarios (
	usu_id 			INT PRIMARY KEY AUTO_INCREMENT,
	usu_nombre 		VARCHAR(150) NOT NULL,
	usu_correo 		VARCHAR(100) NOT NULL UNIQUE,
	usu_telefono 	VARCHAR(20),
	usu_password 	VARCHAR(255) NOT NULL,
    usu_docnum		VARCHAR(20) UNIQUE,
	rol_id 			INT,
	tipdoc_id 		INT,
    usu_activo      BOOLEAN NOT NULL DEFAULT TRUE,
    usu_origen      ENUM('registro', 'formulario', 'admin') NOT NULL DEFAULT 'registro',
	FOREIGN KEY (tipdoc_id) REFERENCES tipo_de_documento (tipdoc_id),
	FOREIGN KEY (rol_id) REFERENCES rol (rol_id)
);

CREATE TABLE tokens (
    tok_id             INT PRIMARY KEY AUTO_INCREMENT,
    token              VARCHAR(255) NOT NULL,
    tipo               ENUM('activacion', 'recuperacion') NOT NULL DEFAULT 'recuperacion',
    fecha_expiracion   DATETIME NOT NULL,
    usu_id             INT,
    FOREIGN KEY (usu_id) REFERENCES usuarios (usu_id) ON DELETE CASCADE
);

-- =============================
-- 2. PERSONALIZACIÓN DE PRODUCTOS
-- =============================

CREATE TABLE opcion_personalizacion (
	opc_id 		INT PRIMARY KEY AUTO_INCREMENT,
	opc_nombre 	VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE valor_personalizacion (
	val_id 		INT PRIMARY KEY AUTO_INCREMENT,
    val_nombre 	VARCHAR(100) NOT NULL,
    val_imagen 	VARCHAR(250),
    opc_id 		INT,
    FOREIGN KEY (opc_id) REFERENCES opcion_personalizacion (opc_id) ON DELETE CASCADE
);

CREATE TABLE personalizacion (
	per_id 			INT PRIMARY KEY AUTO_INCREMENT,
    per_fecha 		DATE NOT NULL,
    usu_id_cliente 	INT,
    FOREIGN KEY (usu_id_cliente) REFERENCES usuarios (usu_id) ON DELETE SET NULL
);

CREATE TABLE detalle_personalizacion (
	det_id 	INT PRIMARY KEY AUTO_INCREMENT,
    per_id 	INT,
    val_id 	INT,
    FOREIGN KEY (per_id) REFERENCES personalizacion (per_id) ON DELETE CASCADE,
    FOREIGN KEY (val_id) REFERENCES valor_personalizacion (val_id)
);

-- =============================
-- 3. GESTIÓN DE PEDIDOS
-- =============================

CREATE TABLE estado_pedido(
	est_id 		INT PRIMARY KEY AUTO_INCREMENT,
	est_nombre 	VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE pedido (
	ped_id 				INT PRIMARY KEY AUTO_INCREMENT,
    ped_codigo 			VARCHAR(100) NOT NULL UNIQUE,
    ped_fecha_creacion 	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ped_comentarios 	VARCHAR(250),
    est_id 				INT,
    per_id 				INT,
    usu_id_empleado 	INT,
    FOREIGN KEY (est_id) REFERENCES estado_pedido (est_id),
    FOREIGN KEY (per_id) REFERENCES personalizacion (per_id),
    FOREIGN KEY (usu_id_empleado) REFERENCES usuarios (usu_id) ON DELETE SET NULL
);

CREATE TABLE foto_producto_final (
	fot_id 				INT PRIMARY KEY AUTO_INCREMENT,
    fot_imagen_final 	VARCHAR(250) NOT NULL,
    fot_fecha_subida 	DATE,
    ped_id 				INT,
    FOREIGN KEY (ped_id) REFERENCES pedido (ped_id) ON DELETE CASCADE
);

CREATE TABLE render_3d (
	ren_id 				INT PRIMARY KEY AUTO_INCREMENT,
	ren_imagen 			VARCHAR(100) NOT NULL,
	ren_fecha_aprobacion DATE,
	ped_id 				INT,
	FOREIGN KEY (ped_id) REFERENCES pedido (ped_id) ON DELETE CASCADE
);

-- =============================
-- 4. EXPERIENCIA DEL CLIENTE
-- =============================

CREATE TABLE contacto_formulario (
    con_id          INT PRIMARY KEY AUTO_INCREMENT,
    usu_id          INT NULL,
    con_nombre      VARCHAR(150) NOT NULL,
    con_correo      VARCHAR(100),
    con_telefono    VARCHAR(30),
    con_mensaje     TEXT NOT NULL,
    con_fecha_envio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    con_via         ENUM('formulario', 'whatsapp') DEFAULT 'formulario',
    con_terminos    BOOLEAN NOT NULL,
    con_estado      ENUM('pendiente','atendido','archivado') NOT NULL DEFAULT 'pendiente',
    con_notas       TEXT,
    usu_id_admin    INT NULL,
    FOREIGN KEY (usu_id) REFERENCES usuarios(usu_id) ON DELETE SET NULL,
    FOREIGN KEY (usu_id_admin) REFERENCES usuarios(usu_id) ON DELETE SET NULL
);

CREATE TABLE portafolio_inspiracion (
    por_id           INT PRIMARY KEY AUTO_INCREMENT,
    por_titulo       VARCHAR(150) NOT NULL,
    por_descripcion  TEXT,
    por_imagen       VARCHAR(250) NOT NULL,
    por_video        VARCHAR(250),
    por_categoria    VARCHAR(100),
    por_fecha        DATETIME DEFAULT CURRENT_TIMESTAMP,
    usu_id           INT,
    FOREIGN KEY 	 (usu_id) REFERENCES usuarios(usu_id) ON DELETE SET NULL
);