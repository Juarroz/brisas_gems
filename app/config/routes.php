<?php
// Definir las rutas: método + path => Controller@acción
return [

    // ======================
    // Autenticación (ejemplo)
    // ======================
    'GET /'           => 'sistemausuarios/AuthController@showLogin',   // raíz = login
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
];