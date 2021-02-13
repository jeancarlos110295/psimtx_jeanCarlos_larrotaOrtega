import { mapGetters, mapState, Store } from 'vuex'

const controlUsers = {
    computed: {
        ...mapGetters(['getLoginState'])
    },
    methods: {
        redirecUserRol(){
            if(this.getLoginState.rol != "admin"){
                this.$router.push({
                    path : '/Usuario'
                })
            }
        }
    }
}

export default controlUsers