<template>
    <div>
        <div class="pb-4">
            <b-table striped responsive small :items="allHospitals" :fields="fields"></b-table>
        </div>

        <b-button variant="outline-primary" v-b-modal.modal-prevent-closing>Agregar Hospital</b-button>

        <b-modal
        id="modal-prevent-closing"
        ref="modal"
        centered
        title="Ingresar nuevo Hospital"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk"
        >
        <form ref="form" @submit.stop.prevent="handleSubmit">
            <b-form-group
            label="Nombre"
            label-for="name-input"
            invalid-feedback="Name is required"
            :state="nameState"
            >
            <b-form-input
                id="name-input"
                v-model="name"
                :state="nameState"
                required
            ></b-form-input>
            </b-form-group>
        </form>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: [],

    data() {
        return {
            allHospitals: [],
            hospitals: [],
            allConsultations: [],
            name: '',
            fields: [
                {
                    label: 'Id',
                    key: 'hospital_id'
                },
                {
                    label: 'Nombre',
                    key: 'name'
                },
                {
                    label: 'Cantidad Consultorias',
                    key: 'numConsultations'
                },
            ]
        }
    },

    created() {
        this.getHospitals()
        
    },

    methods: {
        async getHospitals() {
            var response = await axios.get('gethospitals')
            this.hospitals = response.data.slice()
            this.getConsultations()
            
        },

        async getConsultations() {
            var response = await axios.get('getconsultations')
            this.allConsultations = response.data.slice()
            this.toListHospitals()
        },

        toListHospitals() {
            var count = 0
            this.hospitals.forEach(hospital => {
                this.allConsultations.forEach(consultation => {
                    if (consultation.hospital_id == hospital.id) {
                        count += 1
                        
                    }
                })
                this.allHospitals.push({
                    hospital_id: hospital.id,
                    name: hospital.name,
                    numConsultations: count
                })
                count = 0
            })
        },

        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        resetModal() {
            this.name = ''
            this.nameState = null
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.handleSubmit()
        },
        async handleSubmit() {
            if (!this.checkFormValidity()) {
            return
            }
            
            var response = await axios.post('newhospital', {name: this.name})
            this.update()
            this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })
        },

        update(){
            this.allHospitals = []
            this.hospitals = []
            this.allConsultations = []
            this.getHospitals()
        }
    }
}
</script>