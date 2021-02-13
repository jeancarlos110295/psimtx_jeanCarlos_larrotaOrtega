Requerimientos:

La aplicación debe estar compuesta por 3 Capas:

    1. Capa de usuario (Front-end): Puede usar Vue, React, AngularJs (Preferiblemente pero no es limitante).

    2. Capa de negocios (Back-end): Puede usar Laravel (Preferiblemente pero no es limitante)., NodeJs, Codeigniter.

    3. Capa de Datos: Mysql (Solo Base datos relacional).

La prueba consiste en una aplicación que contenga las siguientes funcionalidades:

    1. Un Login de usuario con 2 perfiles: 1 de usuario común y otro de administrador.

    2. Una vista de registro de usuario común con los campos Nombres, Email y clave:

        a. Todos los campos son requeridos.

        b. Campo email con validación de email.

        c. Campo Clave con mínimo 6 caracteres, máximo 16 y que solo soporte estos caracteres (*.#?¿ )

    3. Una vista para usuario común donde selecciones de un listado intereses un máximo de 5 y que se muestren otros usuarios que al menos contenga 2 intereses similares a los seleccionados por usuario común.

    4. Este listado de usuarios se debe actualizar cada vez que un usuario común se registre con un intervalo de 30 segundos como mínimo.

    5. Al refrescar los datos debe persistir la sesión activa y los datos en pantalla.

    6. Debe haber un botón de cerrar sesión.

    7. Al dar botón Back del navegador debe redireccionar al login si la sesión no se encuentra activa.

    8. La vista administradora debe tener un formulario para crear, editar y eliminar los intereses que se muestra los usuarios comunes.

    9. La vista administradora debe mostrar los usuarios registrados y poder cambiar su clave de acceso u bloquear.


Instalacion de la API:
    Ejecutar los siguientes comandos artisan:
    - php artisan optimize
    - php artisan migrate
    - php artisan passport:install
    - php artisan db:seed