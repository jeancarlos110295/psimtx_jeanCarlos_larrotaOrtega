import axios from 'axios'

export default {
    registrarUsuario({commit , state}, payload){
        return new Promise( (resolve , reject) => {
            axios.post('Usuarios/store', payload)
            .then( response => {
                resolve(response);
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    loginUsuario({commit , state}, payload){
        return new Promise( (resolve , reject) => {
            axios.post('Auth/login', payload)
            .then( response => {
                let data = response.data.msg;

                commit('setLoginState', {
                    accion: "localStorage",
                    token: data.token,
                    rol: data.user.rol,
                    name: data.user.UserName
                })

                resolve(response);
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    dataUsuarios({commit , state}, payload){
        return new Promise( (resolve , reject) => {
            axios.get('Usuarios/index')
            .then( response => {
                resolve(response.data.data);
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    setEstadoUser({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.post('Usuarios/updateEstado', payload)
            .then( response => {
                resolve(response)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    updateClaveUsuario({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.post('Usuarios/updateClave', payload)
            .then( response => {
                resolve(response)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    dataIntereses({commit , state}, payload){
        return new Promise( (resolve , reject) => {
            axios.get('Intereses/index')
            .then( response => {
                resolve(response.data.data);
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    guardarInteres({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.post('Intereses/store', payload)
            .then( response => {
                resolve(response)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    viewInteres({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.get('Intereses/view/'+payload.identificador)
            .then( response => {
                resolve(response.data.data.interes)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    actualizarInteres({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.post('Intereses/update/'+payload.identificador , {
                _method : "PUT",
                interes : payload.interes
            })
            .then( response => {
                resolve(response)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

    eliminarInteres({commit , state}, payload){ 
        return new Promise( (resolve , reject) => {
            axios.post('Intereses/delete/'+payload.identificador, {
                _method : "DELETE"
            })
            .then( response => {
                resolve(response)
            })
            .catch( errorResponse => {
                reject(errorResponse)
            })
        })
    },

}