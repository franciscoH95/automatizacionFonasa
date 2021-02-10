<template>
    <div>
        <b-card bg-variant="light" header="Pacientes Fumadores" header-class="text-center">
            <b-table striped responsive small :items="patients" :fields="fields"></b-table>
        </b-card>
    </div>
</template>

<script>
export default {
    props: [],

    data() {
        return {
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
                {
                    label: 'Años de Fumador',
                    key: 'smokerYears'
                }
            ],
            patients: []
        }
    },

    created() {
        this.fetchSmokers()
    },

    methods: {
        async fetchSmokers() {
            var response = await axios.get('fetchsmokers')
            this.toListSmokers(response.data)
        },

        toListSmokers(smokers) {
            smokers.forEach(smoker => {
                if (smoker.patient.type == 'child') {
                    smoker.patient.type = 'Niño'
                } else if (smoker.patient.type == 'young') {
                    smoker.patient.type = 'Joven'
                } else {
                    smoker.patient.type = 'Anciano'
                }
                this.patients.push({
                    name: smoker.patient.name,
                    age: smoker.patient.age,
                    numHistoryMedical: smoker.patient.num_medical_history,
                    priority: smoker.patient.priority,
                    risk: smoker.patient.risk,
                    category: smoker.patient.type,
                    smokerYears: smoker.category.years_smoker
                })
            })    
        }
    }
}
</script>