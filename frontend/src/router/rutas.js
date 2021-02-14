export default 
[
    {
        path: '*',
        view: 'http/404',
        meta:{
            requiresAuth: false
        }
    },
    {
        path: '/',
        view: 'Home',
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/RegistroDeUsuario',
        name: 'RegistroDeUsuario',
        view: 'Usuarios/Store',
        meta:{
            requiresAuth: false
        }
    },
    {
        path: '/Login',
        name: 'Login',
        view: 'Usuarios/Store',
        meta:{
            requiresAuth: false
        }
    },
    {
        path: '/Logout',
        name: 'Logout',
        view: 'Usuarios/Store',
        meta:{
            requiresAuth: false
        }
    },
    {
        path: '/Administracion',
        view: 'Usuarios/Admin',
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/Usuario',
        view: 'Usuarios/User',
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/ModuloUsuarios',
        view: 'Usuarios/ModuloUsuarios',
        meta:{
            requiresAuth: true
        }
    }
]