<?php
// Definir las rutas: método + path => Controller@acción
return [
    // Autenticación
    'GET /'         => 'AuthController@showLogin',
    'POST /login'   => 'AuthController@login',
    'POST /registro'=> 'AuthController@register',

    // Usuarios
    'GET /usuarios' => 'UsuarioController@index',

    // Contacto
    'GET /contacto' => 'ContactoController@index',
    'POST /contacto'=> 'ContactoController@crear'
];
