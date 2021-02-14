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
                    <template v-slot:top>
                        <v-toolbar
                                flat
                            >
                                <v-toolbar-title>
                                    Intereses
                                </v-toolbar-title>

                                <v-divider
                                class="mx-4"
                                inset
                                vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                

                                <v-btn
                                    color="primary"
                                    dark
                                    class="mb-2"
                                    @click="InteresesAccion('', 'showFormAgregar')"
                                >
                                    Agregar
                                </v-btn>
                        </v-toolbar>
                    </template>


                    <template v-slot:item.actions="{ item }">
                        <v-btn 
                            color="blue"
                            text 
                            @click="InteresesAccion(item.actions.identificador, 'showFormActualizar')"
                        >
                            Editar
                        </v-btn>

                        <v-btn
                            color="error"
                            text
                            @click="ProcesarEliminacion(item.actions.identificador , 'showDialogEliminar')"
                        >
                            Eliminar
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
                        <span class="headline" v-if="accionBtnDialog == 'guardar' ">Nuevo Interes</span>
                        <span class="headline" v-if="accionBtnDialog == 'actualizar' ">Actualizar Interes</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                cols="12"
                                >
                                    <v-form
                                        ref="formularioInteres"
                                        v-model="validacion"
                                        lazy-validation
                                    >
                                        <v-text-field
                                            v-model="interes"
                                            :rules="interesReglas"
                                            :disabled="disabledButtonsDialog"
                                            label="Interes"
                                            required
                                            name="interesInput"
                                        ></v-text-field>
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
                            @click="guardarInteres()"
                            :disabled="disabledButtonsDialog"
                            v-if="accionBtnDialog == 'guardar' "
                        >
                            Guardar
                        </v-btn>
                        
                        <v-btn
                            color="success"
                            text
                            @click="actualizarInteres()"
                            :disabled="disabledButtonsDialog"
                            v-if="accionBtnDialog == 'actualizar' "
                        >
                            Actualizar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <ResponsesErroresHttp></ResponsesErroresHttp>
        </v-row>

        <CoreConfirmDialog
            ref="dialogEliminar_1"
            :confirmEliminar="flagDialogEliminar"
            :disabledCampos="disabledButtonsDialog"
        ></CoreConfirmDialog>

        <CoreLoading v-if="getLoadPeticionesAjax"></CoreLoading>
    </v-container>
</template>

<script>
import { mapGetters, mapState, Store } from 'vuex'
import controlUsers from '@/mixins/controlUsers'

export default {
    mixins: [controlUsers],
    name: 'ModuloIntereses',

    data: () => ({
        headers: [
            {
                text: 'Interes',
                align: 'start',
                sortable: false,
                value: 'interes',
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
        accionBtnDialog: "",
        identificador: "",
        interes: "",
        interesReglas: [
            v => !!v || 'EL campo Interes es requerido.'
        ],
        validacion: true,
        flagDialogEliminar: false
    }),
    computed: {
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    methods:{
        getData(){
            this.data.splice(0, this.data.length)
            this.loading = true

            let p = (p) => {
                this.data.push(p)
            };

            this.$store.dispatch('dataIntereses')
            .then( response => {
                this.loading = false
                
                if(response.length > 0){
                    for(let i in response){
                        let dataR = response[i];

                        let objn = {
                            registro: dataR.registro,
                            actualizado: dataR.actualizado,
                            interes: dataR.interes,
                            actions: {
                                identificador: dataR.identificador
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

        InteresesAccion(id, accion){
            if(accion == "showFormAgregar" || accion == "showFormActualizar"){ 
                this.dialog = true
                this.interes = ""

                try{
                    this.$refs.formularioInteres.resetValidation()
                }catch(error){

                }
            }

            switch(accion){
                case "showFormAgregar":
                    this.accionBtnDialog = "guardar"
                break;

                case "showFormActualizar":
                    this.accionBtnDialog = "actualizar"
                    this.identificador = id
                    this.viewInteres()
                break;
            }
        },

        viewInteres(){
            this.disabledButtonsDialog = true
            this.dialog = true

            this.$store.dispatch('viewInteres',{
                identificador: this.identificador
            })
            .then( response => {
                this.interes = response
                this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
            })
            .catch( errorResponse => {
                this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
            })
            .finally(finall => {
                this.disabledButtonsDialog = false
            })
        },

        guardarInteres(){
            if(this.$refs.formularioInteres.validate()){
                this.loading = true
                this.disabledButtonsDialog = true

                this.$store.dispatch('guardarInteres',{
                    interes: this.interes
                })
                .then( response => {
                    this.getData()
                    this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                })
                .catch( errorResponse => {
                    this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                })
                .finally(finall => {
                    this.dialog = false
                    this.disabledButtonsDialog = false
                })
            }
        },

        actualizarInteres(){
            if(this.$refs.formularioInteres.validate()){
                this.loading = true
                this.disabledButtonsDialog = true

                this.$store.dispatch('actualizarInteres',{
                    interes: this.interes,
                    identificador: this.identificador
                })
                .then( response => {
                    this.getData()
                    this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                })
                .catch( errorResponse => {
                    this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                })
                .finally(finall => {
                    this.identificador = ""
                    this.dialog = false
                    this.disabledButtonsDialog = false
                })
            }
        },

        ProcesarEliminacion(id, accion){
            switch(accion){
                case "showDialogEliminar":
                    this.identificador = id
                    this.flagDialogEliminar = true
                break;

                case "eliminar":
                    this.loading = true
                    this.disabledButtonsDialog = true

                    this.$store.dispatch('eliminarInteres', {
                        identificador: this.identificador
                    })
                    .then( response => {
                        this.getData()
                        this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                    })
                    .catch( errorResponse => {
                        this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                    })
                    .finally(finall => {
                        this.disabledButtonsDialog = false
                        this.flagDialogEliminar = false
                    })
                break;
            }
        },

        CloseDialogEliminar(){
            alert("holar")
        }
    },
    mounted(){
        this.redirecUserRol()
        this.getData()
    }
}
</script>