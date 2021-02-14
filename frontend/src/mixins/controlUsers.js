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
        },
        redirectNoAutenticado(rep){
            if(typeof rep.response.data.msg === "string"){
                if(rep.response.data.msg == "No autenticado"){
                    this.$store.commit('setLoginState', {accion : 'clearSesion'})
                    
                    this.$router.push({
                        path : '/Login'
                    })
                }
            }
        }
    }
}

export default controlUsers