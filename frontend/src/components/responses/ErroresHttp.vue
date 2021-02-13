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
                <v-alert
                    v-for="(index, value) in getErrorsResponse"
                    :key="value"
                    dense
                    type="error"
                >
                    {{ index }}
                </v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters} from 'vuex'

export default {
    name: 'ResponsesErroresHttp',
    data () {
        return {}
    },
    computed: {
        ...mapGetters([
            'getErrorsResponse'
        ])
    }
}
</script>