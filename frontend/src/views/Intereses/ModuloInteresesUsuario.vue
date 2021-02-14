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
                <v-card>
                    <v-card-title>
                        <div>
                            <span class="headline">Seleccionar Intereses</span>
                        </div>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                cols="12"
                                >
                                    <v-form
                                        ref="formularioSeleccionInteres"
                                        v-model="validacion"
                                        lazy-validation
                                    >
                                        <v-select
                                            v-model="interesesSeleccionados"
                                            :items="interesesListado"
                                            label="Intereses"
                                            multiple
                                            chips
                                            hint="No seleccionar más de 5 intereses"
                                            persistent-hint
                                            item-text="interes"
                                            item-value="identificador"
                                            :disabled="flagProressCircular"
                                        ></v-select>
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
                            @click="clearIntereses()"
                            :disabled="flagProressCircular"
                        >
                            Limpiar Intereses Seleccionados
                        </v-btn>
                        
                        <v-spacer></v-spacer>

                        <v-btn
                            color="blue darken-1"
                            text
                            @click="enviarIntereses()"
                            :disabled="flagProressCircular"
                        >
                            Enviar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>


            <v-col
                cols="6"
            >
                <v-card>
                    <v-card-title>
                        <div>
                            <span class="headline">Intereses Similares</span>
                        </div>
                    </v-card-title>

                    <v-card-text style="height:500px !important;overflow:auto;">
                        <v-progress-circular
                            :size="70"
                            :width="7"
                            color="purple"
                            indeterminate
                            v-if="flagProressCircular"
                        ></v-progress-circular>

                        <div v-if="!flagProressCircular">
                            <v-list v-for="(index , value) in returnResultaSimi" :key="value">
                                <v-list-group
                                    prepend-icon="mdi-account-circle"
                                >
                                    <template v-slot:activator>
                                        <v-list-item-title>
                                            {{ index.nombreUsuario }}
                                        </v-list-item-title>
                                    </template>

                                    <v-list-group
                                        no-action
                                        sub-group
                                    >
                                        <template v-slot:activator>
                                            <v-list-item-title>
                                                Intereses
                                            </v-list-item-title>
                                        </template>

                                        <v-list-item v-for="(j , v) in index.interesesSimilares" :key="v">
                                            <v-list-item-title v-text="j.interes"></v-list-item-title>
                                        </v-list-item>
                                    </v-list-group>
                                </v-list-group>
                            </v-list>
                        </div>
                    </v-card-text>
                </v-card>
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
    name: 'ModuloInteresesUsuario',
    data: () => ({
        validacion: true,
        interesesListado: [],
        interesesSeleccionados: [],
        listadoUsuarios: [],
        resultadoSimilares: [],
        flagProressCircular: false
    }),
    computed: {
        returnResultaSimi(){
            return this.resultadoSimilares
        },

        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    methods:{
        getUsuarios(){
            this.listadoUsuarios.splice(0, this.listadoUsuarios.length)
            
            let p = (p) => {
                this.listadoUsuarios.push(p)
            };

            this.$store.dispatch('dataUsuariosPublicos')
            .then( response => {

                if(response.length > 0){
                    for(let i in response){
                        let dataR = response[i];

                        p(dataR)
                    }
                }

                this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
            })
            .catch( errorResponse => {
                this.redirectNoAutenticado(errorResponse)

                this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
            })
            .finally(finall => {
                this.$store.commit('setLoadPeticionesAjax', {accion : 'hide'});
            })
        },
        getData(){// return false;
            this.interesesListado.splice(0, this.interesesListado.length)
            this.$store.commit('setLoadPeticionesAjax', {accion : 'show'});

            let p = (p) => {
                this.interesesListado.push(p)
            };

            this.$store.dispatch('dataInteresesPublico')
            .then( response => {

                if(response.length > 0){
                    for(let i in response){
                        let dataR = response[i];

                        p(dataR)
                    }
                }

                this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
            })
            .catch( errorResponse => {
                this.redirectNoAutenticado(errorResponse)

                this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
            })
            .finally(finall => {
            })
        },

        clearIntereses(){
            this.interesesSeleccionados.splice(0 , this.interesesSeleccionados.length)
        },

        enviarIntereses(){
            if(this.interesesSeleccionados.length == 0){
                alert("Debe seleccionar al menos 1 interes de la lista.")
            }else if(this.interesesSeleccionados.length > 5){
                alert("No se pueden seleccionar mas de 5 intereses.")
                this.interesesSeleccionados.splice(-1)
            }else{
                this.resultadoSimilares.splice(0 , this.resultadoSimilares.length)

                this.flagProressCircular = true

                let p = (p) => {
                    this.resultadoSimilares.push(p)
                };

                this.$store.dispatch('enviarIntereses', {interes : this.interesesSeleccionados})
                .then( response => {
                    let data = response.data.msg
                    
                    for(let i in data){
                        let datos = data[i]
                        let idUsuario = i
                        let nombreUsuario = ""

                        for(let j in this.listadoUsuarios){
                            let user = this.listadoUsuarios[j]

                            if(user.identificador == idUsuario){
                                nombreUsuario = user.nombre
                                break;
                            }
                        }

                        let obj = {
                            nombreUsuario: nombreUsuario,
                            interesesSimilares: datos
                        }

                        p(obj)
                    }

                    this.$store.commit('setErrorsResponse', {accion: "resetErrors"})
                })
                .catch( errorResponse => {
                    this.redirectNoAutenticado(errorResponse)
                    
                    this.$store.commit('setErrorsResponse', {accion: "setErrors" , errors : errorResponse})
                })
                .finally(finall => {
                    this.flagProressCircular = false
                })
            }
        }
    },
    mounted(){
        this.redirecAdminRol()
        this.getData()
        this.getUsuarios()
    }
}
</script>