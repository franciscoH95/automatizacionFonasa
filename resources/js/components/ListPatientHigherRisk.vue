<template>
    <div>
        <b-card bg-variant="light" header="Pacientes con mayor riesgo" header-class="text-center">
            <b-row>
                <b-col md="2"></b-col>
                <b-col md="8">
                    <b-input-group
                        key="sm"
                        size="sm"
                        class="mb-3"
                        prepend="N° Historia Clinica"
                    >
                        <b-form-input
                        v-model="valueFetch"
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button size="sm" text="Button" variant="outline-info" @click="fetchPatients()">Buscar</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
                <b-col md="2"></b-col>
            </b-row>

            <div v-if="fetchPatient != null && fetchPatient != 'does not exist'">
                <b-alert show>
                    Nombre: {{fetchPatient.name}} <br>
                    Edad: {{fetchPatient.age}} <br>
                    N° Historia Clinica: {{fetchPatient.num_medical_history}} <br>
                    Prioridad: {{fetchPatient.priority}} <br>
                    Riesgo: {{fetchPatient.risk}} <br>
                    Categoria: {{fetchPatient.type}}
                </b-alert>
            </div>

            <div v-if="fetchPatient == 'does not exist'">
                <b-alert show variant="danger">Ficha Clinica no existe</b-alert>
            </div>

            <b-table striped responsive small :items="patients" :fields="fields"></b-table>
            
        </b-card>
    </div>
</template>

<script>
export default {
    props: [],

    data() {
        return {
            patients: [],
            fetchPatient: null,
            valueFetch: '',
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
                }
            ]
        }
    },

    methods: {
        async fetchPatients() {
            this.patients = []
            this.fetchPatient = null
            var response = await axios.post('fetchpatients', {'value': parseInt(this.valueFetch)})
            this.toListPatients(response.data)
        },

        toListPatients(data) {
            if (data.fetchedPatient == null) {
                this.fetchPatient = 'does not exist'
            } else {
                if (data.fetchedPatient.type == 'child') {
                    data.fetchedPatient.type = 'Niño'
                } else if (data.fetchedPatient.type == 'young') {
                    data.fetchedPatient.type = 'Joven'
                } else {
                    data.fetchedPatient.type = 'Anciano'
                }
                this.fetchPatient = data.fetchedPatient
            }

            data.allPatients.sort(function(a, b) {
                if (a.risk > b.risk) {
                    return 1;
                }
                if (a.risk < b.risk) {
                    return -1;
                }
                return 0;
            });

            data.allPatients.reverse()
            
            data.allPatients.forEach(patient => {
                if (patient.risk > data.fetchedPatient.risk) {

                    if (patient.type == 'child') {
                        patient.type = 'Niño'
                    } else if (patient.type == 'young') {
                        patient.type = 'Joven'
                    } else {
                        patient.type = 'Anciano'
                    }

                    this.patients.push({
                        name: patient.name,
                        age: patient.age,
                        numHistoryMedical: patient.num_medical_history,
                        priority: patient.priority,
                        risk: patient.risk,
                        category: patient.type
                    })    
                }
                
            })
        },
    }
}
</script>