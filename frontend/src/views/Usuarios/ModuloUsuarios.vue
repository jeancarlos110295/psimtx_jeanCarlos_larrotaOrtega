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
                    :headers="headers"
                    :items="data"
                    :items-per-page="5"
                    class="elevation-1"
                ></v-data-table>
            </v-col>
        </v-row>
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
        ],
        data: []
    }),
    computed: {
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    methods: {
        getData(){
            this.$store.dispatch('getDataUsuarios')
            .then( response => {
                console.log(response)
            })
            .
            catch( errorResponse => {

            })
            .finally(finall => {

            })
        }
    },
    mounted(){
        this.redirecUserRol()
    },
    created(){
        this.getData()
    }
}
</script>
