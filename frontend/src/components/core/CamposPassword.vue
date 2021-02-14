<template>
    <div>
        <v-text-field
            v-model="password"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="passwordReglas"
            :type="showPassword ? 'text' : 'password'"
            label="Clave"
            counter
            name="claveUsuario"
            @click:append="showPassword = !showPassword"
            :disabled="disabledCampos"
        ></v-text-field>

        <v-text-field
            v-model="passwordConfirm"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="passwordConfirmReglas"
            :type="showPassword ? 'text' : 'password'"
            label="Confirmar Clave"
            counter
            name="confirmarClave"
            @click:append="showPassword = !showPassword"
            v-if="accionVista == 'viewFormRegistro'"
            :disabled="disabledCampos"
        ></v-text-field>
    </div>
</template>

<script>
export default {
    name: 'CoreCamposPassword',
    data: () => ({
        showPassword: false,
        password: '',
        passwordConfirm: '',
        passwordReglas: [
            v => !!v || 'El campo Clave es requerido.',
            v => /^([A-Za-z\d\*\.\#\?\¿]){6,16}$/i.test(v) || 'Clave incorrecta, debe contener minimo 6 caracteres y no más de 16, los caracteres permitidos son (*.#?¿).'
        ]
    }),
    computed: {
        passwordConfirmReglas(){
            return [
                !!this.passwordConfirm || 'El campo Confirmación de Clave es requerido.',
                this.passwordConfirm === this.password || "Las Claves no coinciden."
            ]
        }
    },
    methods:{
        resetCampos(){
            this.password = ''
            this.passwordConfirm  = ''
        }
    },
    props: {
        accionVista: {
            type: String,
            default: 'viewFormRegistro'
        },
        disabledCampos: {
            type: Boolean,
            default: false
        }
    }
}
</script>