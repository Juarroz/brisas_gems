<?php

// app/config/routes.php
// Definir las rutas: método + path => Controller@acción
return [

    
    // Landige page
    'GET /' => 'HomeController@index',

    // ======================
    // Sistema y Usuarios
    // ======================
    
    
    'POST /login'     => 'sistemausuarios/AuthController@login',
    'POST /registro'  => 'sistemausuarios/AuthController@register',

    'GET /usuarios'   => 'sistemausuarios/UsuarioController@index',
    'GET /gestion-usuarios' => 'sistemausuarios/GestionUsuariosController@index',

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