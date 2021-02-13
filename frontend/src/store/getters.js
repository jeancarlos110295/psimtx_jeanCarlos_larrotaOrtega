import state from "./state";

export default {
    getErrorsResponse: (state) => state.erroresResponse,
    getLoadPeticionesAjax : (state) => state.showForm,

    getLoginState(state){
        let textRol = ""
        
        switch(state.rolUser){
            case "user":
                textRol = "Usuario"
            break;

            case "admin":
                textRol = "Administrador"
            break;
        }

        return {
            stateLogin : state.stateLogin,
            tokenUser : state.tokenUser,
            rolUser : textRol,
            userName : state.userName,
            rol: state.rolUser
        }
    }
}