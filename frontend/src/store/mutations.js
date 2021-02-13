export default {
    setErrorsResponse(state, payload){
        if(payload.accion == "setErrors" || payload.accion == "resetErrors"){
            state.erroresResponse.splice(0 , state.erroresResponse.length)
        }

        if(payload.accion == "setErrors"){
            let a = [];

            if(typeof payload.errors.response.data.msg === "string"){
                a.push(payload.errors.response.data.msg);
            }
    
            if(typeof payload.errors.response.data.msg === "object"){
                for(let er in payload.errors.response.data.msg){
                    let obj = payload.errors.response.data.msg[er];
                
                    for(let ms in obj){
                        a.push(obj[ms]);
                    }
                }
            }
    
            state.erroresResponse = a
        }
    },

    setLoadPeticionesAjax(state, payload){
        switch(payload.accion){
            case "show":
                state.showForm = true;
            break;

            case "hide":
                state.showForm = false;
            break;
        }
    },

    setLoginState(state, payload){
        if(payload.accion == "localStorage"){
            state.stateLogin = true
            state.tokenUser = payload.token
            state.rolUser = payload.rol
            state.userName = payload.name

            localStorage.setItem('tokenUser' , payload.token)
            localStorage.setItem('rolUser' , payload.rol)
            localStorage.setItem('userName' , payload.name)
            localStorage.setItem('stateLogin' , true)
        }

        if(payload.accion == "updateState"){
            state.tokenUser = localStorage.getItem('tokenUser')
            state.rolUser = localStorage.getItem('rolUser')
            state.userName = localStorage.getItem('userName')
            state.stateLogin = localStorage.getItem('stateLogin')
        }

        if(payload.accion == "clearSesion"){
            state.stateLogin = false
            state.tokenUser = ""
            state.rolUser = ""
            state.userName = ""

            localStorage.clear()
        }
    }
}