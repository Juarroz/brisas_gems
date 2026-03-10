<?php

// app/config/routes.php
// Definir las rutas: método + path => Controller@acción
return [

    // ======================
    // LANDING PAGE
    // ======================
    'GET /' => 'HomeController@index',

    // ======================
    // AUTENTICACIÓN
    // ======================

    'POST /registro'  => 'sistemausuarios/AuthController@register',
    'GET /login'    => 'seguridad/AuthController@showLogin',
    'POST /login'   => 'seguridad/AuthController@handleLogin',
    'GET /logout'   => 'seguridad/AuthController@handleLogout',

    // ======================
    // DASHBOARD
    // ======================

    'GET /dashboard' => 'dashboard/DashboardController@showDashboard',

    // ✅ AGREGAR ESTAS RUTAS NUEVAS:
    'GET /admin/dashboard' => 'dashboard/DashboardController@showDashboard',
    'GET /designer/dashboard' => 'dashboard/DashboardController@showDashboard', 
    'GET /user/dashboard' => 'dashboard/DashboardController@showDashboard',

    // ======================
    // SISTEMA Y USUARIOS
    // ======================

    'GET /gestion-usuarios'         => 'sistemausuarios/GestionUsuariosController@index',
    'GET /usuarios/registrar'       => 'sistemausuarios/UsuarioController@showRegistrationForm',
    'POST /usuarios/registrar'      => 'sistemausuarios/UsuarioController@handleRegistration',
    'GET /usuarios'                 => 'sistemausuarios/UsuarioController@listUsers',
    'GET /usuarios/inactivos'       => 'sistemausuarios/UsuarioController@listInactiveUsers',
    'GET /usuarios/editar'          => 'sistemausuarios/UsuarioController@showEditForm',
    'POST /usuarios/actualizar'     => 'sistemausuarios/UsuarioController@handleUpdate',
    'POST /usuarios/cambiar-estado' => 'sistemausuarios/UsuarioController@handleChangeStatus',

    // ======================
    // GESTIÓN DE PEDIDOS
    // ======================

    'GET /pedido'                   => 'gestionpedidos/PedidoController@index',
    'POST /pedido'                  => 'gestionpedidos/PedidoController@crear',
    'GET /pedidos'                  => 'gestionpedidos/PedidoController@listPedidos',
    'GET /pedidos/detalles'         => 'gestionpedidos/PedidoController@showPedidoDetails',
    'POST /pedidos/actualizar'      => 'gestionpedidos/PedidoController@handleUpdateStatus',

    // ======================
    // EXPERIENCIA DE USUARIO
    // ======================

    // Cliente (formulario de contacto)
    "GET /contacto"        => "experienciausuarios/ContactoController@mostrar", // muestra el form
    "POST /contacto"       => "experienciausuarios/ContactoController@crear",   // envía datos del form

    // Admin (gestión de contactos)
    "GET /admin/contactos"        => "experienciausuarios/GestionContactosController@listar",
    "POST /admin/contactos/update" => "experienciausuarios/GestionContactosController@actualizar",
    "POST /admin/contactos/delete" => "experienciausuarios/GestionContactosController@eliminar",

    // Portafolio de inspiración (cliente y gestión básica)
    "GET /inspiracion"         => "experienciausuarios/PortafolioInspiracionController@index",
    "POST /inspiracion"        => "experienciausuarios/PortafolioInspiracionController@index",
    

    // ======================
    // PERSONALIZACIÓN DE JOYAS
    // ======================

    // Cliente 
    'GET /personalizar'          => 'personalizacionproductos/PersonalizacionController@mostrar',
    'POST /personalizar/guardar' => 'personalizacionproductos/PersonalizacionController@guardar',

    // Admin (gestión de opciones y valores)
    'GET /admin/opciones'        => 'personalizacionproductos/GestionPersonalizacionController@listarOpciones',
    'GET /admin/valores'         => 'personalizacionproductos/GestionPersonalizacionController@listarValores',
];