<template>
    <div>
        <b-card bg-variant="light" header="Ingreso de paciente" header-class="text-center">
            <b-form>
                <div v-if="faseForm == '1'">
                    <b-form-group id="input-group-name" label="Nombre:" label-for="input-name" description="Ingrese nombre completo.">
                        <b-form-input
                        id="input-name"
                        name="input-name"
                        v-model="form.name"
                        type="text"
                        placeholder="'Juan Perez'"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-age" label="Edad:" label-for="input-age">
                        <b-form-input
                        id="input-age"
                        v-model="form.age"
                        type="number"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-medicalhistory" label="Numero historia clinica:" label-for="input-medicalhistory">
                        <b-form-input
                        id="input-medicalhistory"
                        v-model="form.numMedicalHistory"
                        placeholder="'123456'"
                        required
                        ></b-form-input>
                    </b-form-group>
                    <div v-if="errors.length > 0">
                        <b-alert show variant="danger">
                            <div v-for="(error, index) in errors" :key="index">
                                {{error}}
                            </div>
                        </b-alert>
                    </div>
                    <div class="d-flex justify-content-end">
                        <b-button variant="primary" @click="verifyAge()">Siguiente</b-button>
                    </div>
                </div>

                <div v-if="faseForm == '2'">
                    <h5>Datos del paciente</h5>
                    <h6>Nombre: {{ form.name }}</h6>
                    <h6>Edad: {{ form.age }}</h6>
                    <h6>N° historial clinico: {{ form.numMedicalHistory }}</h6>
                    <div v-if="typePatient == 'elder'">
                        <b-form-checkbox
                        id="checkbox-elder"
                        v-model="hasDiet"
                        name="checkbox-elder"
                        >
                        ¿Tiene una dieta? 
                        </b-form-checkbox>
                    </div>
                    <div v-if="typePatient == 'young'">
                        <b-form-checkbox
                        id="checkbox-young"
                        v-model="isSmoker"
                        name="checkbox-young"
                        @change="activeForm()"
                        >
                        ¿Es fumador? 
                        </b-form-checkbox>

                        <b-form-group id="input-group-years-smoker" label="Cantidad años fumador:" label-for="input-years-smoker">
                            <b-form-input
                            id="input-years-smoker"
                            v-model="yearsSmoker"
                            type="number"
                            required
                            :disabled="disable"
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div v-if="typePatient == 'child'">
                        <b-form-group 
                        id="input-group-weight-height" 
                        label="Relacion peso estatura:" 
                        label-for="input-weight-height"
                        description="ingrese valor entre 1 y 4"
                        >
                            <b-form-input
                            id="input-weight-height"
                            v-model="weightHeight"
                            type="number"
                            required
                            ></b-form-input>
                        </b-form-group>
                    </div>
                    <div v-if="errors.length > 0">
                        <b-alert show variant="danger">
                            <div v-for="(error, index) in errors" :key="index">
                                {{error}}
                            </div>
                        </b-alert>
                    </div>
                    <div class="d-flex justify-content-around pt-2">
                        <b-button variant="primary" @click="back()">volver</b-button>
                        <b-button variant="primary" @click="onSubmit()">Ingresar</b-button>
                    </div>
                </div>
            </b-form>
        </b-card>
    </div>
</template>

<script>
export default {
    props: ['user'],

    data() {
        return {
            form: {
                name: '',
                age: '',
                numMedicalHistory: '',
            },
            weightHeight: '',
            isSmoker: false,
            yearsSmoker: 0,
            hasDiet: false,
            faseForm: '1',
            typePatient: '',
            disable: true,
            errors: [],
            boxConfirmation: ''
        }
    },

    methods: {
        async onSubmit(){
            var response = await this.validateForm2()
            if (this.errors.length == 0) {
                var priority = await this.calculatePriority()
                var risk = await this.calculateRisk(priority)

                var response = await axios.post('newpatient', {
                    'name': this.form.name,
                    'age': parseInt(this.form.age),
                    'num_medical_history': parseInt(this.form.numMedicalHistory),
                    'priority': priority,
                    'risk': risk,
                    'hospital_id': this.user.hospital_id,
                    'type_patient': this.typePatient,
                    'weight_height': parseInt(this.weightHeight),
                    'is_a_smoker': this.isSmoker,
                    'years_smoker': parseInt(this.yearsSmoker),
                    'has_a_diet': this.hasDiet
                })

                this.showMsgConfirmation()

            }
        },

        showMsgConfirmation() {
            this.boxConfirmation = ''
            this.$bvModal.msgBoxOk('Paciente a sido ingresado exitosamente', {
            title: 'Confirmacion',
            size: 'sm',
            buttonSize: 'sm',
            okVariant: 'success',
            headerClass: 'p-2 border-bottom-0',
            footerClass: 'p-2 border-top-0',
            centered: true
            })
            .then(value => {
                this.boxConfirmation = value
                this.resetData()
            })
            .catch(err => {
                // An error occurred
            })
        },

        calculatePriority(){
            if (this.typePatient == 'child') {
                if (this.form.age > 0 && this.form.age < 6) {
                    return parseInt(this.weightHeight) + 3
                }
                if (this.form.age > 5 && this.form.age < 13) {
                    return parseInt(this.weightHeight) + 2
                }
                if (this.form.age > 12 && this.form.age < 16) {
                    return parseInt(this.weightHeight) + 1
                }
            }
            if (this.typePatient == 'young') {
                if (this.isSmoker == true) {
                    return (parseInt(this.yearsSmoker)/4) + 2
                } else {
                    return 2
                }
            }
            if (this.typePatient == 'elder') {
                if (this.hasDiet == true) {
                    if (this.form.age > 59 && this.form.age < 101) {
                        return (parseInt(this.form.age)/20) + 4
                    } else {
                        return (parseInt(this.form.age)/30) + 3
                    }
                } else {
                    return (parseInt(this.form.age)/30) + 3
                }
            }
        },

        calculateRisk(priority) {
            if (this.typePatient == 'child' || this.typePatient == 'young') {
                return (parseInt(this.form.age)*priority)/100
            }
            if (this.typePatient == 'elder') {
                return ((parseInt(this.form.age)*priority)/100) + 5.3
            }
        },

        async verifyAge(){
            var response = await this.validateForm1()
            if (this.errors.length == 0) {
                this.errors = []
                this.faseForm = '2'
                if (this.form.age > 0 && this.form.age < 16) {
                    this.typePatient = 'child'
                } else if (this.form.age > 15 && this.form.age < 41) {
                    this.typePatient = 'young'
                } else if (this.form.age > 40) {
                    this.typePatient = 'elder'
                }    
            }
        },

        validateForm1(){
            this.errors = []
            if (this.form.name.length == 0) {
                this.errors.push("debe ingresar nombre!")
            }
            if (this.form.age.length == 0) {
                this.errors.push("debe ingresar edad!")
            }
            if (this.form.age < 1 || this.form.age > 100) {
                this.errors.push("edad fuera de rango (1-100)!")
            }
            if (this.form.numMedicalHistory.length == 0) {
                this.errors.push("debe ingresar num. historial clinico!")
            }
        },

        validateForm2(){
            this.errors = []
            if (this.typePatient == 'child') {
                if (this.weightHeight.length == 0) {
                    this.errors.push("relcion de peso y estatura no debe estar vacio!")
                }
                if (this.weightHeight < 1 || this.weightHeight > 4) {
                    this.errors.push("relacion de peso y estatura fuera de rango!")
                }
            }
            if (this.typePatient == 'young') {
                if (this.isSmoker == true) {
                    if (this.yearsSmoker.length == 0) {
                        this.errors.push("cantidad de años fumador no puede estar vacio!")
                    }
                    if (this.yearsSmoker < 1) {
                        this.errors.push("el valor de años fumador debe ser mayor a 0!")
                    }
                    if (this.yearsSmoker > (this.form.age - 18)) {
                        this.errors.push("los años de fumador no puede ser mayor a la resta de edad y la edad legal!")
                    }
                }
            }
        },

        activeForm(){
            if (this.isSmoker == true) {
                this.disable = false
            } else {
                this.disable = true
            }
        },

        back(){
            this.faseForm = '1'
        },

        resetData() {
            this.form.name = ''
            this.form.age = ''
            this.form.numMedicalHistory = ''
            this.weightHeight = ''
            this.isSmoker = false
            this.yearsSmoker = ''
            this.hasDiet = false
            this.faseForm = '1'
            this.typePatient = ''
            this.disable = true
            this.errors = []
            this.boxConfirmation = ''
        }
    },

    computed: {

    }
}
</script>

<style>

</style>