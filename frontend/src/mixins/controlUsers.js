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
        },
        redirecAdminRol(){
            if(this.getLoginState.rol != "user"){
                this.$router.push({
                    path : '/Administracion'
                })
            }
        }
    }
}

export default controlUsers