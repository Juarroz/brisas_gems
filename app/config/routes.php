<?php
// Definir las rutas: método + path => Controller@acción
return [
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
    'GET /personalizaciones'            => 'personalizaciones/PersonalizacionController@listPersonalizaciones',
    'GET /personalizaciones/detalles'   => 'personalizaciones/PersonalizacionController@showPersonalizacionDetails',
    'GET /contactos'            => 'contactos/ContactoController@listContactos',
    'GET /contactos/detalles'   => 'contactos/ContactoController@showContactoDetails',
    'POST /contactos/actualizar'=> 'contactos/ContactoController@handleUpdate',
];