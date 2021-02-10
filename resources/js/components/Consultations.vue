<template>
    <div>
        <div class="pb-2">
            <b-card border-variant="success" header="Consultas Libres" header-class="text-center">
                <b-overlay :show="showOverlay" rounded="sm">
                    <div v-for="(consultation, index) in freeConsultations" :key="index">
                        <b-card class="mb-2" style="max-width: 100%; max-height: 5rem;">
                            <h6 class="mb-1">{{ consultation.specialist_name }}</h6> 
                            <div class="d-flex justify-content-between">
                                {{ consultation.type_consultation }} <em>{{consultation.state}}</em>
                            </div>
                        </b-card>
                    </div>
                </b-overlay>
            </b-card>
        </div>
        <div class="pb-2">
            <b-card border-variant="danger" header="Consultas Ocupadas" header-bg-variant="transparent" header-class="text-center">
                <b-overlay :show="showOverlay" rounded="sm">
                <div v-for="(consultation, index) in busyConsultations" :key="index">
                    <div v-for="(patient, index) in patients" :key="index">
                        <div v-if="patient.id == consultation.attending_patient">
                            <b-card class="mb-2" style="max-width: 100%; max-height: 5rem;">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">{{ consultation.specialist_name }}</h6>
                                    <em>{{consultation.state}}</em>
                                    
                                </div>
                                <div class="d-flex justify-content-between">
                                    {{ consultation.type_consultation }}
                                    <em>Atendiendo a: {{ patient.name }}</em> 
                                </div>
                            </b-card>
                        </div>
                    </div>
                    
                </div>
                </b-overlay>
            </b-card>  
        </div>
    </div>
</template>

<script>
export default {
    props: ['bus'],

    data() {
        return {
            freeConsultations: [],
            busyConsultations: [],
            patients: [],
            showOverlay: false,
        }
    },

    created() {
        this.showOverlay = true
        this.getConsultations()
        this.getPatients()
    },

    mounted() {
        this.bus.$on('updateConsultations', () => {
            this.update()
        })

        this.bus.$on('freeConsultaions', () => {
            this.breakFreeConsultations()
        })
    },

    methods: {
        async getConsultations() {
            
            var response = await axios.get('getconsultations')
            this.toListConsultations(response.data)
        },

        async getPatients() {
            var patients = []
            var response = await axios.get('getallpatients')
            response.data.forEach(patient => {
                if (patient.attended_by > 0) {
                    patients.push(patient)
                }
            })

            this.patients = patients.slice()
            
        },

        toListConsultations(consultations) {
            var freeconsultations = []
            var busyconsultations = []
            consultations.forEach(consultation => {
                if (consultation.state == 'en espera') {
                    freeconsultations.push(consultation)
                } else if (consultation.state == 'ocupado') {
                    busyconsultations.push(consultation)
                }
            });

            this.freeConsultations = freeconsultations.slice()
            this.busyConsultations = busyconsultations.slice()
            this.showOverlay = false
        },

        update() {
            this.showOverlay = true
            this.getConsultations()
            this.getPatients()
            
        },

        breakFreeConsultations() {
            this.busyConsultations.forEach(consultation => {
                axios.put('freeconsultation', {
                    consultation_id: consultation.id,
                    patient_id: consultation.attending_patient
                })
            })

            this.update()
            this.bus.$emit('updateWaitingPendingRoom')
        },
    }
}
</script>