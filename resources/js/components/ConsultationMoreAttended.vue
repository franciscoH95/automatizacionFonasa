<template>
    <div>
        <b-card bg-variant="light" header="Menu de Atención" header-class="text-center">
            <div v-for="(consultation, index) in fetchedConsultations" :key="index">
                <b-table striped responsive small :items="fetchedConsultations" :fields="fields"></b-table>
            </div>
            
        </b-card>
    </div>
</template>

<script>
export default {
    props: [],

    data(){
        return {
            fetchedConsultations: [],
            fields: [
                {
                    label: 'Especialista',
                    key: 'specialist'
                },
                {
                    label: 'Consulta',
                    key: 'typeConsultation'
                },
                {
                    label: 'N° pacientes atendidos',
                    key: 'numPatient'
                },
            ],
        }
    },

    created() {
        this.fetchConsultation()
    },

    methods: {
        async fetchConsultation(){
            var response = await axios.get('fetchconsultation')
            if (response.data.length == 0) {
                this.fetchedConsultations = null
            } else {
                response.data.forEach(consultation => {
                    this.fetchedConsultations.push({
                        specialist: consultation.specialist_name,
                        typeConsultation: consultation.type_consultation,
                        numPatient: consultation.number_patients
                    })
                });
            }
        }
    }
}
</script>