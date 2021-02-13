export default 
[
    {
        path: '*',
        view: 'http/404'
    },
    {
      path: '/',
      view: 'Home'
    },
    {
        path: '/RegistroDeUsuario',
        name: 'RegistroDeUsuario',
        view: 'Usuarios/Store'
    },
    {
        path: '/Login',
        name: 'Login',
        view: 'Usuarios/Store'
    },
    {
        path: '/Logout',
        name: 'Logout',
        view: 'Usuarios/Store'
    },
    {
        path: '/Administracion',
        view: 'Usuarios/Admin'
    },
    {
        path: '/Usuario',
        view: 'Usuarios/User'
    },
    {
        path: '/ModuloUsuarios',
        view: 'Usuarios/ModuloUsuarios'
    }
]