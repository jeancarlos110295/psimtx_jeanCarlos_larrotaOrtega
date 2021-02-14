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
                            @click="cambiarClave(item.actions.identificador)"
                        >
                            Cambiar Clave
                        </v-btn>

                        <v-btn 
                            color="success"
                            text 
                            @click="cambiarEstado(item.actions.identificador, 1)"
                            v-if="item.actions.estado == 0"
                        >
                            Bloquear
                        </v-btn>

                        <v-btn 
                            color="error"
                            text 
                            @click="cambiarEstado(item.actions.identificador, 0)"
                            v-if="item.actions.estado == 1"
                        >
                            Desbloquear
                        </v-btn>
                    </template>>
                </v-data-table>
            </v-col>

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
        options: {},
        data: []
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

                        let objn = {
                            registro: dataR.registro,
                            actualizado: dataR.actualizado,
                            nombre: dataR.nombre,
                            correo: dataR.correo,
                            perfil: dataR.perfil,
                            estado: dataR.estado,
                            actions: {
                                identificador: dataR.identificador,
                                estado: estadoUser
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
        }
    },
    mounted(){
        this.redirecUserRol()
        this.getData()
    }
}
</script>
