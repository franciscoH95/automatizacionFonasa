<template>
    <div>
        <b-card bg-variant="light" header="Paciente mas Anciano" header-class="text-center">
            <div v-for="(patient, index) in olderPatients" :key="index">
                <b-table striped responsive small :items="olderPatients" :fields="fields"></b-table>
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
            fields: [
                {
                    label: 'Nombre',
                    key: 'name'
                },
                {
                    label: 'Edad',
                    key: 'age'
                },
                {
                    label: 'N° Historia Clinica',
                    key: 'numHistoryMedical'
                },
                {
                    label: 'Prioridad',
                    key: 'priority'
                },
                {
                    label: 'Riesgo',
                    key: 'risk'
                },
                {
                    label: 'Categoria',
                    key: 'category'
                },
            ],
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
                
                this.olderPatients.push({
                    name: patient.name,
                    age: patient.age,
                    numHistoryMedical: patient.num_medical_history,
                    priority: patient.priority,
                    risk: patient.risk,
                    category: patient.type,
                })
                
                
            })
        }
    },
}
</script>