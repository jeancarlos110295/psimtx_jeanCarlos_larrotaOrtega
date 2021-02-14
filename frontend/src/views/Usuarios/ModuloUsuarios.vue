<template>
    <v-container>
        <v-row
            align="center"
            justify="center"
            no-gutters
        >
            <v-col
                cols="10"
            >
                <v-data-table
                    v-if="!getLoadPeticionesAjax"
                    :headers="headers"
                    :items="data"
                    :items-per-page="5"
                    :loading="loading"
                    class="elevation-1"
                    loading-text="Cargando por favor espere"
                    no-data-text="No hay datos para mostrar"
                    no-results-text="No se encontraron datos"
                    :footer-props="{
                        'items-per-page-text' : 'Filas por página.',
                        'items-per-page-all-text' : 'Todos'
                    }"
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn 
                            color="blue"
                            text 
                            @click="cambiarClave(item.actions.identificador , 'showDialog')"
                        >
                            Cambiar Clave
                        </v-btn>

                        <v-btn 
                            color="success"
                            text 
                            @click="cambiarEstado(item.actions.identificador, 1)"
                            v-if="item.actions.estado == 0 && item.actions.rol == 'user'"
                        >
                            Bloquear
                        </v-btn>

                        <v-btn 
                            color="error"
                            text 
                            @click="cambiarEstado(item.actions.identificador, 0)"
                            v-if="item.actions.estado == 1 && item.actions.rol == 'user'"
                        >
                            Desbloquear
                        </v-btn>
                    </template>>
                </v-data-table>
            </v-col>


            <v-dialog
                v-model="dialog"
                persistent
                max-width="500px"
            >
                <v-card>
                    <v-card-title>
                        <span class="headline">Cambiar Clave</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                cols="12"
                                >
                                    <v-form
                                        ref="formularioCambioClave"
                                        v-model="validacion"
                                        lazy-validation
                                    >
                                        <CoreCamposPassword
                                            ref="ComponentPassword_2"
                                            :disabledCampos="disabledButtonsDialog"
                                        ></CoreCamposPassword>
                                    </v-form>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialog = false"
                            :disabled="disabledButtonsDialog"
                        >
                            Cancelar
                        </v-btn>
                        
                        <v-btn
                            color="success"
                            text
                            @click="cambiarClave('' , 'envioRequest')"
                            :disabled="disabledButtonsDialog"
                        >
                            Actualizar Clave
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <ResponsesErroresHttp></ResponsesErroresHttp>
        </v-row>

        <CoreLoading v-if="getLoadPeticionesAjax"></CoreLoading>
    </v-container>
</template>

<script>
import { mapGetters, mapState, Store } from 'vuex'
import controlUsers from '@/mixins/controlUsers'

export default {
    mixins: [controlUsers],

    name: 'ModuloUsuarios',
    data: () => ({
        headers: [
            {
                text: 'Usuario',
                align: 'start',
                sortable: false,
                value: 'nombre',
            },
            {
                text: 'E-mail',
                align: 'start',
                value: 'correo',
            },
            {
                text: 'Rol',
                align: 'start',
                value: 'perfil',
            },
            {
                text: 'Estado',
                align: 'start',
                value: 'estado',
            },
            {
                text: 'Fecha de Registro',
                align: 'start',
                value: 'registro',
            },
            {
                text: 'Fecha de Actualización',
                align: 'start',
                value: 'actualizado',
            },
            { text: '', value: 'actions', sortable: false }
        ],
        loading: false,
        data: [],
        dialog: false,
        disabledButtonsDialog: false,
        identificador: "",
        validacion: true
    }),
    computed: {
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    methods: {
        getData(){
            this.data = []
            this.loading = true

            let p = (p) => {
                this.data.push(p)
            };

            this.$store.dispatch('dataUsuarios')
            .then( response => {
                this.loading = false
                
                if(response.length > 0){
                    for(let i in response){
                        let dataR = response[i];

                        let estadoUser = (dataR.estado == "Bloqueado") ? 1 : 0;
                        let textRol = ""

                        switch(dataR.perfil){
                            case "Usuario":
                                textRol = "user"
                            break;

                            case "Administrador":
                                textRol = "admin"
                            break;
                        }


                        let objn = {
                            registro: dataR.registro,
                            actualizado: dataR.actualizado,
                            nombre: dataR.nombre,
                            correo: dataR.correo,
                            perfil: dataR.perfil,
                            estado: dataR.estado,
                            actions: {
                                identificador: dataR.identificador,
                                estado: estadoUser,
                                rol: textRol
                            }
                        }

                        p(objn)
                    }
                }

                this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
            })
            .catch( errorResponse => {
                this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
            })
            .finally(finall => {
            })
        },

        cambiarEstado(id , estado){
            this.loading = true

            this.$store.dispatch('setEstadoUser', {
                identificador: id,
                estado: estado
            })
            .then( response => {
                this.getData()
                this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
            })
            .catch( errorResponse => {
                this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
            })
            .finally(finall => {
            })
        },

        cambiarClave(id, accion){
            switch(accion){
                case "showDialog":
                    this.dialog = true
                    this.identificador = id
                    try{
                        this.$refs.ComponentPassword_2.resetValidation()
                    }catch(error){

                    }
                    this.$refs.ComponentPassword_2.resetCampos()
                break;

                case "envioRequest":
                    if(this.$refs.formularioCambioClave.validate()){
                        this.disabledButtonsDialog = true
                        this.$store.dispatch('updateClaveUsuario', {
                            identificador: this.identificador,
                            password : this.$refs.ComponentPassword_2.password,
                            password_confirmation : this.$refs.ComponentPassword_2.passwordConfirm,
                        })
                        .then( response => {
                            this.disabledButtonsDialog = false
                            this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                        })
                        .catch( errorResponse => {
                            this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                        })
                        .finally(finall => {
                            this.dialog = false
                            this.identificador = ""
                            this.disabledButtonsDialog = false
                        })
                    }
                break;
            }

            
        }
    },
    mounted(){
        this.redirecUserRol()
        this.getData()
    }
}
</script>
