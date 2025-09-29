<?php

// app/config/routes.php
// Definir las rutas: método + path => Controller@acción
return [
    // Landige page
    'GET /' => 'HomeController@index',

    // === RUTAS EXISTENTES DE TU EQUIPO ===
    'POST /registro'  => 'sistemausuarios/AuthController@register',
    'GET /gestion-usuarios' => 'sistemausuarios/GestionUsuariosController@index',
    "POST /contacto/crear"    => "experienciausuarios/ContactoController@crear",
    
    // === NUESTRAS RUTAS DEL PANEL DE ADMINISTRACIÓN ===

    // --- Autenticación ---
    'GET /login'    => 'seguridad/AuthController@showLogin',
    'POST /login'   => 'seguridad/AuthController@handleLogin',
    'GET /logout'   => 'seguridad/AuthController@handleLogout',

    // --- Dashboard ---
    'GET /dashboard' => 'dashboard/DashboardController@showDashboard',

    // --- Usuarios ---
    // --- LÍNEA AÑADIDA ---
    'GET /usuarios/registrar'       => 'sistemausuarios/UsuarioController@showRegistrationForm',
    'POST /usuarios/registrar'      => 'sistemausuarios/UsuarioController@handleRegistration',
    'GET /usuarios'                 => 'sistemausuarios/UsuarioController@listUsers',
    'GET /usuarios/inactivos'       => 'sistemausuarios/UsuarioController@listInactiveUsers',
    'GET /usuarios/editar'          => 'sistemausuarios/UsuarioController@showEditForm',
    'POST /usuarios/actualizar'     => 'sistemausuarios/UsuarioController@handleUpdate',
    'POST /usuarios/cambiar-estado' => 'sistemausuarios/UsuarioController@handleChangeStatus',
    
    // ... (El resto de las rutas no cambia) ...
    'GET /pedidos'              => 'gestionpedidos/PedidoController@listPedidos',
    'GET /pedidos/detalles'     => 'gestionpedidos/PedidoController@showPedidoDetails',
    'POST /pedidos/actualizar'  => 'gestionpedidos/PedidoController@handleUpdateStatus',

    // ======================
    // Sistema y Usuarios
    // ======================
    

    // ======================
    // Experiencia de Usuario
    // ======================

    // Cliente (formulario de contacto)
    "GET /contacto"        => "experienciausuarios/ContactoController@mostrar", // muestra el form
    "POST /contacto"       => "experienciausuarios/ContactoController@crear",   // envía datos del form

    // Admin (gestión de contactos)
    "GET /admin/contactos"        => "experienciausuarios/GestionContactosController@listar",
    "POST /admin/contactos/update" => "experienciausuarios/GestionContactosController@actualizar",
    "POST /admin/contactos/delete" => "experienciausuarios/GestionContactosController@eliminar",


    // ======================
    // Gestión de Pedidos
    // ======================
    'GET /pedido'     => 'gestionpedidos/PedidoController@index',
    'POST /pedido'    => 'gestionpedidos/PedidoController@crear',

    // ======================
    // Personalización de Joyas
    // ======================
    'GET /personalizar'          => 'personalizacionproductos/PersonalizacionController@mostrar',
    'POST /personalizar/guardar' => 'personalizacionproductos/PersonalizacionController@guardar',

    'GET /admin/opciones'        => 'personalizacionproductos/GestionPersonalizacionController@listarOpciones',
    'GET /admin/valores'         => 'personalizacionproductos/GestionPersonalizacionController@listarValores',

];