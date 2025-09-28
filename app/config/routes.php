<?php

// app/config/routes.php
// Definir las rutas: método + path => Controller@acción
return [

    
    // Landige page
    'GET /' => 'HomeController@index',

     
    // ======================
    // Autenticación (ejemplo)
    // ======================
    
    'POST /login'     => 'sistemausuarios/AuthController@login',
    'POST /registro'  => 'sistemausuarios/AuthController@register',

    // ======================
    // Sistema y Usuarios
    // ======================
    'GET /usuarios'   => 'sistemausuarios/UsuarioController@index',
    'GET /gestion-usuarios' => 'sistemausuarios/GestionUsuariosController@index',

    // ======================
    // Experiencia de Usuario
    // ======================
    "GET /contacto"           => "experienciausuarios/ContactoController@listar",
    "POST /contacto/crear"    => "experienciausuarios/ContactoController@crear",
    "POST /contacto/update"   => "experienciausuarios/ContactoController@actualizar",
    "POST /contacto/delete"   => "experienciausuarios/ContactoController@eliminar",

    'GET /contacto-usuario'  => 'experienciausuarios/ContactoUsuarioController@manejarPeticion',
    'POST /contacto-usuario' => 'experienciausuarios/ContactoUsuarioController@manejarPeticion',

    // ======================
    // Gestión de Pedidos
    // ======================
    'GET /pedido'     => 'gestionpedidos/PedidoController@index',
    'POST /pedido'    => 'gestionpedidos/PedidoController@crear',

    // ======================
    // Personalización de Joyas
    // ======================
    'GET /personalizar'          => 'personalizacionproductos/PersonalizacionController@mostrar',
    'POST /personalizar/guardar' => 'personalizacionproducto/PersonalizacionController@guardar',

    'GET /admin/opciones'        => 'personalizacionproductos/GestionPersonalizacionController@listarOpciones',
    'GET /admin/valores'         => 'personalizacionproductos/GestionPersonalizacionController@listarValores',
];