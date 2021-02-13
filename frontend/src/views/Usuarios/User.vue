<template>
    <v-container>
        <center>
            Usuario
        </center>


    </v-container>
</template>

<script>
import { mapGetters, mapState, Store } from 'vuex'

export default {
    name: 'User',
    data: () => ({

    }),
    computed: {
        ...mapGetters(['getLoadPeticionesAjax', 'getLoginState'])
    },
    mounted(){
        
    },
    created(){

    }
}
</script>