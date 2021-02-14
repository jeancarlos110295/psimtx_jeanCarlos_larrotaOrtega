<template>
    <v-container>
        <v-row
            align="center"
            justify="center"
            no-gutters
            v-if="!getLoadPeticionesAjax"
        >
            <v-col
                cols="6"
            >   
                <center>
                    <h3 v-if="accionVista() == 'viewFormRegistro'">
                        Crear Cuenta.
                    </h3>

                    <h3 v-if="accionVista() == 'viewFormLogin'">
                        Iniciar Sesión.
                    </h3>
                </center>

                <v-form
                    ref="formularioRegistroUsuario"
                    v-model="validacion"
                    lazy-validation
                >
                    <v-text-field
                        v-model="nombreUsuario"
                        :rules="nombreReglas"
                        label="Nombre"
                        required
                        name="nombreUsuario"
                        v-if="accionVista() == 'viewFormRegistro'"
                    ></v-text-field>

                    <v-text-field
                        v-model="correo"
                        :rules="correoReglas"
                        label="E-mail"
                        required
                        name="correoUsuario"
                    ></v-text-field>

                    <CoreCamposPassword 
                        :accionVista="accionVista()"
                        ref="ComponentPassword_1"
                    ></CoreCamposPassword>

                    <v-btn
                        :disabled="!validacion"
                        color="success"
                        class="mr-4"
                        @click="registrarUsuario"
                        v-if="accionVista() == 'viewFormRegistro'"
                    >
                        Enviar.
                    </v-btn>

                    <v-btn
                        :disabled="!validacion"
                        color="success"
                        class="mr-4"
                        @click="loginUsuario"
                        v-if="accionVista() == 'viewFormLogin'"
                    >
                        Ingresar.
                    </v-btn>

                </v-form>
            </v-col>

            <ResponsesErroresHttp></ResponsesErroresHttp>
        </v-row>


        <CoreLoading v-if="getLoadPeticionesAjax"></CoreLoading>
    </v-container>
</template>


<script>
import { mapGetters, mapState, Store } from 'vuex'

export default {
    //mixins: [],

    name: 'Store',  
    //mixins: [],
    data: () => ({
        validacion: true,
        nombreUsuario: '',
        nombreReglas: [
            v => !!v || 'EL campo Nombre es requerido.'
        ],

        correo: '',
        correoReglas: [
            v => !!v || 'El campo Correo es requerido.',
            v => /.+@.+\..+/.test(v) || 'Correo invalido',
        ],
        pathRuta: ''
    }),
    computed:{
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    methods: {
        accionVista(){
            switch(this.$route.path){
                case "/RegistroDeUsuario":
                    return "viewFormRegistro"
                break;

                case "/Login":
                    return "viewFormLogin"
                break;
            }
        },
        resetFormulario(){
            this.$refs.ComponentPassword_1.password = ''
            this.$refs.ComponentPassword_1.passwordConfirm = ''
            this.correo = ''
            this.nombreUsuario = ''
        },
        registrarUsuario () { 
            if(this.$refs.formularioRegistroUsuario.validate()){
                this.$store.commit('setLoadPeticionesAjax', {accion : 'show'});

                this.$store.dispatch('registrarUsuario', {
                    password : this.$refs.ComponentPassword_1.password,
                    password_confirmation : this.$refs.ComponentPassword_1.passwordConfirm,
                    email : this.correo,
                    name : this.nombreUsuario
                })
                .then( response => {
                    alert("Usuario Registrado.")
                    this.resetFormulario()

                    this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                })
                .catch( errorResponse => {
                    this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                })
                .finally( fina => {
                    this.$store.commit('setLoadPeticionesAjax', {accion : 'hide'});
                });
            }
        },

        loginUsuario(){
            if(this.$refs.formularioRegistroUsuario.validate()){
                this.$store.commit('setLoadPeticionesAjax', {accion : 'show'});

                this.$store.dispatch('loginUsuario', {
                    password : this.$refs.ComponentPassword_1.password,
                    email : this.correo
                })
                .then( response => {
                    this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                    
                    switch(this.getLoginState.rol){
                        case "admin":
                            this.$router.push({
                                path : '/Administracion'
                            })
                        break;

                        case "user":
                            this.$router.push({
                                path : '/Usuario'
                            })
                        break;
                    }
                })
                .catch( errorResponse => {
                    this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                })
                .finally( fina => {
                    this.$store.commit('setLoadPeticionesAjax', {accion : 'hide'});
                });
            }
        }
    },
    mounted(){
        if(this.$route.path == "/Logout"){
            this.$store.commit('setLoginState', {accion: "clearSesion"})
            
            this.$router.push({
                path : '/Login'
            })
        }
        
        if(this.getLoginState.stateLogin){
            this.$router.push({
                path : '/'
            })
        }
    }
}
</script>