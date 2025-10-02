-- ==================================
-- INSERCIONES DE PRUEBA (VERSIÓN CORREGIDA Y MEJORADA)
-- ==================================
USE brisas_gems;

-- tabla tipo_de_documento
INSERT INTO tipo_de_documento (tipdoc_nombre) VALUES
('Cédula de ciudadanía'),
('Cédula de extranjería'),
('Pasaporte');

-- tabla rol
INSERT INTO rol (rol_nombre) VALUES
('usuario'),
('administrador'),
('diseñador');


-- Usuario "Guest" para personalizaciones sin registro
INSERT INTO usuarios (
    usu_nombre,
    usu_correo,
    usu_telefono,
    usu_password,
    usu_docnum,
    usu_origen,
    usu_activo,
    tipdoc_id,
    rol_id
) VALUES (
    'Usuario Invitado',
    'guest@brisasgems.com',
    '0000000000',
    '12345678',        -- puede ser un hash o un dummy
    'GUEST-9999',
    'admin',             -- origen: creado por sistema/admin
    true,                -- activo = 1
    1,                   -- tipdoc_id válido (ejemplo: Cédula)
    1                    -- rol_id = cliente (ajusta al id correcto de "cliente")
);
    
-- tabla usuarios (contraseña para todos es: 12345678)
-- La contraseña está hasheada con BCrypt
INSERT INTO usuarios (usu_nombre, usu_correo, usu_telefono, usu_password, rol_id, tipdoc_id, usu_activo, usu_origen, usu_docnum) VALUES
-- administradores (rol_id = 2)
('Ana Administrador', 'ana@gmail.com', '3001000001', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 2, 1, 1, 'admin', '1000001'),
('Catalina López', 'catalina.admin@gmail.com', '3001000002', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 2, 1, 1, 'admin', '1000002'),
('Jorge Herrera', 'jorgeherrera@gmail.com', '3001000003', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 2, 2, 1, 'admin', '1000003'),
-- diseñadores (rol_id = 3)
('Soledad Martínez', 'soledad@gmail.com', '3001000004', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 3, 1, 1, 'admin', '1000004'),
('Tomás Agudelo', 'tomas@gmail.com', '3001000005', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 3, 2, 0, 'admin', '1000005'),
('Paula Cárdenas', 'paula@gmail.com', '3001000006', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 3, 1, 1, 'admin', '1000006'),
-- clientes (rol_id = 1)
('Valentina Castro', 'valentinacastro@gmail.com', '3001000007', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 1, 2, 1, 'registro', '1000007'),
('Santiago Morales', 'santiagomorales@gmail.com', '3001000008', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 1, 1, 1, 'registro', '1000008'),
('Laura Sánchez', 'laurasanchez@gmail.com', '3001000009', '$2a$10$y.6276/Fz6kHmqO2I/O.7.9Wf2Tj0Gq3N9.tYyG2q2dG0q/c0S0mS', 1, 2, 1, 'registro', '1000009');


INSERT INTO opcion_personalizacion (opc_nombre) VALUES 
('Forma de la gema'),       -- opc_id = 1
('Gema central'),           -- opc_id = 2
('Material'),               -- opc_id = 3
('Tamaño de la gema'),      -- opc_id = 4
('Talla del anillo');       -- opc_id = 5

-- ====================
-- VALORES DE OPCIONES
-- ====================

-- Forma de la gema (opc_id = 1)
INSERT INTO valor_personalizacion (val_nombre, opc_id) VALUES
('Redonda',   1),
('Ovalada',   1),
('Cuadrada',  1),
('Corazón',   1);

-- Gema central (opc_id = 2)
INSERT INTO valor_personalizacion (val_nombre, opc_id) VALUES
('Diamante',  2),
('Esmeralda', 2),
('Zafiro',    2),
('Rubí',      2);

-- Material (opc_id = 3)
INSERT INTO valor_personalizacion (val_nombre, opc_id) VALUES
('Oro Amarillo', 3),
('Oro Blanco',   3),
('Oro Rosa',     3),
('Platino',      3),
('Plata',        3);

-- Tamaño de la gema (opc_id = 4)
INSERT INTO valor_personalizacion (val_nombre, opc_id) VALUES
('7 mm', 4),
('8 mm', 4);


-- Talla del anillo (opc_id = 5)
INSERT INTO valor_personalizacion (val_nombre, opc_id) VALUES
('Talla 4',   5),
('Talla 4.5', 5),
('Talla 5',   5),
('Talla 5.5', 5),
('Talla 6',   5),
('Talla 6.5', 5),
('Talla 7',   5),
('Talla 7.5', 5),
('Talla 8',   5),
('Talla 8.5', 5),
('Talla 9',   5);

-- tabla personalizacion (asociados a clientes)
INSERT INTO personalizacion (per_fecha, usu_id_cliente) VALUES
('2023-10-15', 7),
('2023-11-20', 8),
('2024-01-05', 9);

-- tabla detalle_personalizacion
INSERT INTO detalle_personalizacion (per_id, val_id) VALUES
(1, 1), (1, 4), (1, 7), (1, 12), (1, 15),
(2, 2), (2, 5), (2, 8), (2, 11), (2, 14),
(3, 3), (3, 6), (3, 9), (3, 13), (3, 16);

-- tabla estado_pedido
INSERT INTO estado_pedido (est_nombre) VALUES
('diseño'),
('tallado'),
('engaste'),
('pulido'),
('finalizado'),
('cancelado');

-- tabla pedido
INSERT INTO pedido (ped_codigo, ped_fecha_creacion, ped_comentarios, est_id, per_id, usu_id_empleado) VALUES
('p-20231015-001', '2023-10-15 10:00:00', 'Pedido de Valentina', 1, 1, 4),
('p-20231120-002', '2023-11-20 14:30:00', 'Pedido de Santiago', 2, 2, 5),
('p-20240105-003', '2024-01-05 09:00:00', 'Pedido de Laura', 3, 3, 6);

-- tabla contacto_formulario
INSERT INTO contacto_formulario (usu_id, con_nombre, con_correo, con_telefono, con_mensaje, con_via, con_terminos, con_estado) VALUES
(7, 'Valentina Castro', 'valentinacastro@gmail.com', '3001000007', 'Consulta sobre mi pedido p-20231015-001', 'formulario', true, 'pendiente'),
(null, 'Cliente Interesado', 'interesado@email.com', '3105554433', 'Quisiera saber más sobre los anillos de compromiso.', 'whatsapp', true, 'pendiente');