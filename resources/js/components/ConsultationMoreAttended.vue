<template>
    <div>
        <b-card bg-variant="light" header="Menu de Atención" header-class="text-center">
            <div v-for="(consultation, index) in fetchedConsultations" :key="index">
                <b-alert show variant="info">
                    Especialista: {{consultation.specialist_name}} <br>
                    Consulta: {{consultation.type_consultation}} <br>
                    Cantidad de pacientes atendidos: {{consultation.number_patients}}
                </b-alert>
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
                    this.fetchedConsultations.push(consultation)
                });
            }
        }
    }
}
</script>