<template>
    <div>
        <b-card bg-variant="light" header="Paciente mas Anciano" header-class="text-center">
            <div v-for="(patient, index) in olderPatients" :key="index">
                <b-alert show variant="info">
                    Nombre: {{patient.name}} <br>
                    Edad: {{patient.age}} <br>
                    N° Historia Clinica: {{patient.num_medical_history}} <br>
                    Prioridad: {{patient.priority}} <br>
                    Riesgo: {{patient.risk}} <br>
                    Categoria: {{patient.type}}
                </b-alert>
            </div>
        </b-card>
    </div>
</template>

<script>
export default {
    props: [],

    data() {
        return {
            olderPatients: [],
        }
    },

    created() {
        this.fetchOlderPatient()
    },

    methods: {
        async fetchOlderPatient() {
            var response = await axios.get('fetcholderpatient')
            this.toListOlderPatient(response.data)
        },

        toListOlderPatient(patients) {
            patients.forEach(patient => {
                if (patient.type == 'child') {
                    patient.type = 'Niño'
                } else if (patient.type == 'young') {
                    patient.type = 'Joven'
                } else {
                    patient.type = 'Anciano'
                }
                
                this.olderPatients.push(patient)
                
                
            })
        }
    },
}
</script>