<template>
    <div class="container-fluid">
        <div class="d-flex justify-content-center pb-2">
            <h3>{{ user.hospital.name }}</h3>
        </div>
        <div v-if="ruta == null">
            <b-row>
                <b-col xs="12" lg="4">
                    <consultations
                    :bus="bus"
                    ></consultations>  
                </b-col>
                <b-col xs="12" lg="4">
                    <b-card bg-variant="light" header="Menu de Atención" class="text-center">
                        <b-list-group class="pb-4">
                            <b-list-group-item variant="info" button @click="onClick('1')">Atender Paciente</b-list-group-item>
                            <b-list-group-item variant="info" button @click="onClick('2')">Listar Pacientes Mayor Riesgo</b-list-group-item>
                            <b-list-group-item variant="info" button @click="onClick('3')">Listar Pacientes Fumadores Urgentes</b-list-group-item>
                            <b-list-group-item variant="info" button @click="onClick('4')">Paciente Mas Anciano</b-list-group-item>
                            <b-list-group-item variant="info" button @click="onClick('5')">Consulta que más Pacientes a Atendido</b-list-group-item>
                        </b-list-group>
                        <div class="d-flex justify-content-around pb-2">
                            <b-button variant="outline-primary" @click="sendStartCareProcess()">Iniciar Atención</b-button>
                            <b-button variant="outline-success" @click="sendOptimize()">Optimizar Atención</b-button>
                        </div>
                        
                        <b-button variant="outline-danger" @click="sendFreeConsultations()">Liberar Consultas</b-button>
                    </b-card>
                </b-col>
                <b-col xs="12" lg="4">
                    <waiting-room
                    :bus="bus"
                    :hospital="hospital"
                    ></waiting-room>
                </b-col>
            </b-row>
        </div>

        <b-row>
            <b-col></b-col>
            <b-col md="6">

                <div v-if="ruta != null" class="pb-2">
                    <b-button squared variant="outline-secondary" @click="onBack()">ATRAS</b-button>
                </div>
                
                <div v-if="ruta == '1'">
                    <patient-form
                    :user="user"
                    ></patient-form>
                </div>
                
                <div v-if="ruta == '2'">
                    <patient-higher-risk></patient-higher-risk>
                </div>

                <div v-if="ruta == '3'">
                    <urgent-smoker></urgent-smoker>
                </div>

                <div v-if="ruta == '4'">
                    <older-patient></older-patient>
                </div>

                <div v-if="ruta == '5'">
                    <consultation-more-attended></consultation-more-attended>
                </div>
            </b-col>
            <b-col></b-col>
        </b-row>
    </div>
</template>

<script>
import PatientForm from './PatientForm.vue'
import PatientHigherRisk from './ListPatientHigherRisk.vue'
import UrgentSmoker from './UrgentSmoker.vue'
import OlderPatient from './OlderPatient.vue'
import WaitingRoom from './WaitingPendingRooms.vue'
import Consultations from './Consultations.vue'
import ConsultationMoreAttended from './ConsultationMoreAttended.vue'

export default {
    components: {
        PatientForm,
        PatientHigherRisk,
        UrgentSmoker,
        OlderPatient,
        WaitingRoom,
        Consultations,
        ConsultationMoreAttended,
    },
    props: ['user', 'roles', 'hospital'],

    data(){
        return {
            bus: new Vue,
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
                case '4':
                    this.ruta = option
                    break;
                case '5':
                    this.ruta = option
                    break;
                default:
                    break;
            }
        },

        onBack(){
            this.ruta = null
        },

        sendStartCareProcess() {
            this.bus.$emit('startCareProcess')
        },

        sendFreeConsultations() {
            this.bus.$emit('freeConsultaions')
        },

        sendOptimize() {
            this.bus.$emit('optimizeAttention')
        }
    },
}
</script>

<style>

</style>