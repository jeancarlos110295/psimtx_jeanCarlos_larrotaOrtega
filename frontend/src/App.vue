<template>
    <v-app>
        <v-main>
            <v-toolbar
            color="primary"
            dark
            >
                <v-toolbar-title>
                    <v-btn 
                        text
                        to="/"
                    >
                        pruebaPsicometrix
                    </v-btn>
                </v-toolbar-title>

                <v-divider
                class="mx-4"
                vertical
                ></v-divider>

                <span v-if="getLoginState.stateLogin">
                    {{ getLoginState.rolUser }} : {{ getLoginState.userName }}
                </span>

                <v-spacer></v-spacer>

                <v-toolbar-items class="hidden-sm-and-down" v-if="!getLoginState.stateLogin">
                    <v-btn 
                        text
                        to="/RegistroDeUsuario"
                    >
                        Registrarme
                    </v-btn>

                    <v-divider vertical></v-divider>

                    <v-btn 
                        text
                        to="/Login"
                    >
                        Inicio de Sesión
                    </v-btn>
                </v-toolbar-items>


                <v-toolbar-items v-if="getLoginState.rol == 'admin'">
                    <v-btn 
                        text
                        to="/ModuloUsuarios"
                    >
                        Usuarios
                    </v-btn>

                    <v-divider vertical></v-divider>

                    <v-btn 
                        text
                        to="/ModuloIntereses"
                    >
                        Intereses
                    </v-btn>

                    <v-divider vertical></v-divider>
                </v-toolbar-items>


                <v-toolbar-items class="hidden-sm-and-down" v-if="getLoginState.stateLogin">
                    <v-btn 
                        text
                        to="/Logout"
                    >
                        Cerrar Sesión
                    </v-btn>

                    <v-divider vertical></v-divider>

                </v-toolbar-items>
            </v-toolbar>
        </v-main>



        <v-main>
            <core-view />
        </v-main>
    </v-app>
</template>

<script>
import { mapGetters, mapState, Store } from 'vuex'

export default {
    name: 'App',

    data: () => ({}),

    computed: {
        ...mapGetters(['getLoginState'])
    }
};
</script>

<style>
  #core-app-bar {
    width: auto;
  }

  #core-app-bar a {
    text-decoration: none;
  }
</style>