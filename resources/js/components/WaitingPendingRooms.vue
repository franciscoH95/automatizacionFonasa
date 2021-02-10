<template>
    <div>
        <div class="pb-2">
            <b-card bg-variant="light" header="Sala de espera" header-class="text-center">
                <b-table striped small responsive :items="waitingRoom" :fields="fields"></b-table>
            </b-card> 
        </div>
        <div class="pb-2">
            <b-card bg-variant="light" header="Sala pendientes" header-class="text-center">
                <b-table striped small responsive :items="pendingRoom" :fields="fields"></b-table>
            </b-card> 
        </div> 
    </div>
</template>

<script>

export default {
    props: ['bus', 'hospital'],

    data() {
        return {
            waitingRoom: [],
            pendingRoom: [],
            allConsultations: [],
            fields: [
                {
                    label: 'Nombre',
                    key: 'name'
                },
                {
                    label: 'Prioridad',
                    key: 'priority'
                },
                {
                    label: 'Categoria',
                    key: 'type'
                }
            ]
        }
    },

    created() {
        this.getAllPatients()
        this.getConsultations()
    },

    mounted() {
        this.bus.$on('startCareProcess', () => {
            this.startCareProcess()
        })

        this.bus.$on('updateWaitingPendingRoom', () => {
            this.update()
        })

        this.bus.$on('optimizeAttention', () => {
            this.optimizeAtention()
        })
    },

    methods: {
        async getAllPatients() {
            var response = await axios.get('getallpatients')
            this.toListAllPatients(response.data)
        },

        toListAllPatients(patients) {
            patients.forEach(patient => {
                if (patient.type == 'child') {
                    patient.type = 'Niño'
                } else if (patient.type == 'young') {
                    patient.type = 'Joven'
                } else {
                    patient.type = 'Anciano'
                }
                if (this.waitingRoom.length < 5) {
                    if (patient.attended_by == 0) {
                        this.waitingRoom.push(patient) 
                    }
                       
                } else {
                    if (patient.attended_by == 0) {
                        this.pendingRoom.push(patient)
                    }
                }
            })

            this.waitingRoom.sort(((a, b) => b.priority - a.priority))

        },

        async getConsultations() {
            var response = await axios.get('getconsultations')
            this.allConsultations = response.data.slice()
        },

        update(){
            this.waitingRoom = []
            this.pendingRoom = []
            this.getAllPatients()
            this.getConsultations()
            
        },

        startCareProcess() {

            this.allConsultations.forEach(consultation => {
                var newConsultation = consultation
                this.waitingRoom.forEach(patient => {
                    var newPatient = patient
                    if (newPatient.priority > 4 && newConsultation.type_consultation == 'Urgencia') {
                        
                        if (newConsultation.state == 'en espera') {
                            if (newPatient.attended_by == 0) {
                                
                                newConsultation.state = 'ocupado'
                                newConsultation.attending_patient = newPatient.id
                                newPatient.attended_by = newConsultation.id
                                axios.put('updateconsultation', {
                                    patient: newPatient,
                                    consultation: newConsultation
                                })    
                            }
                        }
                        
                    } else if ((newPatient.type == 'Anciano' || newPatient.type == 'Joven') && (newConsultation.type_consultation == 'CGI' && newPatient.priority <= 4)) {
                        if (newConsultation.state == 'en espera') {
                            if (newPatient.attended_by == 0) {
                                
                                newConsultation.state = 'ocupado'
                                newConsultation.attending_patient = newPatient.id
                                newPatient.attended_by = newConsultation.id
                                axios.put('updateconsultation', {
                                    patient: newPatient,
                                    consultation: newConsultation
                                })    
                            }
                        }   
                    } else if ((newPatient.type == 'Niño' && newPatient.priority <= 4) && newConsultation.type_consultation == 'Pediatría') {
                        if (newConsultation.state == 'en espera') {
                            
                            if (newPatient.attended_by == 0) {
                                newConsultation.state = 'ocupado'
                                newConsultation.attending_patient = newPatient.id
                                newPatient.attended_by = newConsultation.id
                                axios.put('updateconsultation', {
                                    patient: newPatient,
                                    consultation: newConsultation
                                })    
                            }
                        }
                    }
                })
            })

            this.update()
            this.bus.$emit('updateConsultations')
        },

        optimizeAtention(){
            var array_optimized = []
            var first = []
            var second = []
            var third = []

            this.pendingRoom.forEach(patient => {
                
                if (patient.priority >= 4.5) {
                    first.push(patient)
                } else if (patient.type == 'Niño' || patient.type == 'Anciano') {
                    second.push(patient)
                } else if (patient.type == 'Joven') {
                    third.push(patient)
                }
            })

            first.sort(((a, b) => b.priority - a.priority))
            second.sort(((a, b) => b.priority - a.priority))
            third.sort(((a, b) => b.priority - a.priority))

            if (first.length > 0) {
                first.forEach(patient => {
                    array_optimized.push(patient)
                })    
            }
            
            if (second.length > 0) {
                second.forEach(patient => {
                    array_optimized.push(patient)
                })    
            }
            
            if (third.length > 0) {
                third.forEach(patient => {
                    array_optimized.push(patient)
                })    
            }
            
            if (array_optimized.length > 0) {
                this.pendingRoom = array_optimized.slice()    
            }
            

        }
    }
}
</script>

