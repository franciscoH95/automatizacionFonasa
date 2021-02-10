<template>
    <div>
        <div class="pb-4">
            <b-table striped responsive small :items="allUsers" :fields="fields"></b-table>
        </div>

        <b-button variant="outline-primary" v-b-modal.modal-prevent-closing>Registrar Usuario</b-button>

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
            >
                <b-form-input
                    id="name-input"
                    v-model="name"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
            label="Apellido"
            label-for="lastname-input"
            invalid-feedback="Nombre es requerido"
            
            >
                <b-form-input
                    id="lastname-input"
                    v-model="lastName"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
            label="Email"
            label-for="mail-input"
            invalid-feedback="email es requerido"
            
            >
                <b-form-input
                    id="mail-input"
                    v-model="mail"
                    type="email"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
            label="Contraseña"
            label-for="name-input"
            invalid-feedback="Contraseña requerida"
            >
                <b-form-input
                    id="name-input"
                    v-model="password"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-hospital" label="Hospital" label-for="input-hospital">
                <b-form-select
                id="input-hospital"
                v-model="selectedHospital"
                :options="hospitals"
                required
                ></b-form-select>
            </b-form-group>
            <b-form-group id="input-group-role" label="asignar Rol" label-for="input-role">
                <b-form-select
                id="input-role"
                v-model="selectedRole"
                :options="roles"
                required
                ></b-form-select>
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
            allUsers: [],
            hospitals: [],
            selectedHospital: null,
            roles: [],
            selectedRole: null,
            name: '',
            lastName: '',
            mail: '',
            password: '',
            fields: [
                {
                    label: 'Id',
                    key: 'id'
                },
                {
                    label: 'Nombre',
                    key: 'name'
                },
                {
                    label: 'Apellido',
                    key: 'last_name'
                },
                {
                    label: 'E-mail',
                    key: 'email'
                },
            ]
        }
    },

    created() {
        this.getUsers()
        this.getHospitals()
        this.getRoles()
    },

    methods: {
        async getUsers(){
            var response = await axios.get('getusers')
            response.data.forEach(user => {
                this.allUsers.push({
                    id: user.id,
                    name: user.name,
                    last_name: user.last_name,
                    email: user.email
                })
            });
        },

        async getHospitals() {
            var response = await axios.get('gethospitals')
            response.data.forEach(hospital => {
                this.hospitals.push({
                    text: hospital.name,
                    value: hospital.id
                })
            })
        },

        async getRoles() {
            var response = await axios.get('getroles')
            response.data.forEach(role => {
                this.roles.push({
                    text: role.name,
                    value: role.id
                })
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
            
            var response = await axios.post('newuser', {
                name: this.name,
                last_name: this.lastName,
                email: this.mail,
                password: this.password,
                role: this.selectedRole,
                hospital: this.selectedHospital
            })
            // this.update()
            this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })
        },
    }
}
</script>