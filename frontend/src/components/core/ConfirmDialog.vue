<template>
    <v-container>
		<template>
			<v-row justify="center">
				<v-dialog v-model="confirmEliminar" persistent max-width="290">
					<v-card>
						<v-card-title class="headline">
							¿Eliminar Interes?
						</v-card-title>

						<v-card-text>
							Aceptar para continuar.
						</v-card-text>
						
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn :disabled="disabledCampos" color="blue darken-1" text @click="$parent.flagDialogEliminar = false">Cancelar</v-btn>
							<v-btn :disabled="disabledCampos" color="error" text @click="$parent.ProcesarEliminacion('', 'eliminar')">Aceptar</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-row>
		</template>
    </v-container>
</template>

<script>
export default {
    name: 'CoreConfirmDialog',
    props: {
        confirmEliminar: {
            type: Boolean,
            default: false
        },
        disabledCampos: {
            type: Boolean,
            default: false
        }
    }
}
</script>