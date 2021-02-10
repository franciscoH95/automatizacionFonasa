<template>
    <div class="container-fluid">
        <div v-if="ruta == null">
            <b-row>
                <b-col></b-col>
                <b-col>
                    <b-card bg-variant="light" header="Administrar Hospitales" class="text-center">
                        <b-list-group class="pb-4">
                            <b-list-group-item variant="info" button @click="onClick('1')">Listar Hospitales</b-list-group-item>
                            <b-list-group-item variant="info" button @click="onClick('2')">Listar Usuarios</b-list-group-item>
                            <!-- <b-list-group-item variant="info" button @click="onClick('3')">Listar Hospitales</b-list-group-item> -->
                        </b-list-group>
                    </b-card>
                </b-col>
                <b-col></b-col>
            </b-row>
        </div>
        <b-row>
            <b-col md="3"></b-col>
            <b-col md="6">
                <div v-if="ruta != null" class="pb-2">
                    <b-button squared variant="outline-secondary" @click="onBack()">ATRAS</b-button>
                </div>
                <div v-if="ruta == '1'">
                    <list-hospitals></list-hospitals>
                </div>
                <div v-if="ruta == '2'">
                    <list-users></list-users>
                </div>
            </b-col>
            <b-col md="3"></b-col>
        </b-row>
        
    </div>
</template>

<script>
import ListHospitals from './ListHospitals.vue'
import ListUsers from './ListUsers.vue'
export default {
    components: {
        ListHospitals,
        ListUsers,
    },

    props: [],

    data() {
        return {
            ruta: null,
        }
    },

    methods: {
        onClick(option){
            switch (option) {
                case '1':
                    this.ruta = option
                    break;
                case '2':
                    this.ruta = option
                    break;
                case '3':
                    this.ruta = option
                    break;
                default:
                    break;
            }
        },

        onBack(){
            this.ruta = null
        },
    }
}
</script>