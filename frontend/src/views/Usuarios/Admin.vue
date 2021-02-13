<template>
    <v-container>
        <center>
            Administracion
        </center>


    </v-container>
</template>

<script>
import { mapGetters, mapState, Store } from 'vuex'
import controlUsers from '@/mixins/controlUsers'

export default {
    mixins: [controlUsers],

    name: 'Admin',
    data: () => ({

    }),
    computed: {
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    mounted(){
        this.redirecUserRol()
    },
    created(){

    }
}
</script>