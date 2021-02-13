<template>
    <v-container>
        <v-row
            align="center"
            justify="center"
            no-gutters
        >
            <v-col
                cols="6"
            >
                <v-img 
                :src="img" 
                aspect-ratio="1.7"
                max-width="700"
                ></v-img>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'CoreLoading',
    data () {
        return {
            img : "/loading-ajax.gif"
        }
    }
}
</script>