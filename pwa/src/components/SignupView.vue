<template>

  <form novalidate class="md-layout md-alignment-center-center" @submit.prevent="validateUser">

    <md-card class="md-layout-item md-size-30 md-small-size-100">

      <md-card-header class="md-primary">
        <div class="md-title">
          Create an account
        </div>
      </md-card-header>

      <md-divider></md-divider>

      <md-card-content>

        <div class="md-layout">

          <md-field :class="getValidationClass('first_name')">
            <label for="first-name">First Name</label>
            <md-input type="text" name="first_name" id="first-name" autocomplete="first_name" v-model="form.first_name" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.first_name.required">Your first name is required</span>
          </md-field>

          <md-field :class="getValidationClass('last_name')">
            <label for="last-name">Last Name</label>
            <md-input type="text" name="last_name" id="last-name" autocomplete="last_name" v-model="form.last_name" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.last_name.required">Your last name is required</span>
          </md-field>

          <md-field :class="getValidationClass('email')">
            <label for="signup-email">Email</label>
            <md-input type="email" name="email" id="signup-email" autocomplete="email" v-model="form.email" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.email.required">The email is required</span>
            <span class="md-error" v-else-if="!$v.form.email.email">Invalid email</span>
            <span class="md-error" v-else-if="server_errors.email.state">{{ server_errors.email.message }}</span>
          </md-field>

          <md-field :class="getValidationClass('password')">
            <label for="signup-password">Password</label>
            <md-input type="password" name="password" id="signup-password" autocomplete="password" v-model="form.password" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.password.required">The password is required</span>
            <span class="md-error" v-else-if="server_errors.password.state">{{ server_errors.password.message }}</span>
          </md-field>

          <md-field :class="getValidationClass('password_confirmation')">
            <label for="password-confirmation">Confirm Password</label>
            <md-input type="password" name="password_confirmation" id="password-confirmation" autocomplete="password_confirmation" v-model="form.password_confirmation" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.password_confirmation.required">The password confirmation is required</span>
          </md-field>

        </div>

      </md-card-content>

      <md-divider></md-divider>
      <md-progress-bar md-mode="indeterminate" v-if="sending" />

      <md-card-actions>
        <md-button class="md-default" @click="$router.push({name: 'login'})">Cancel</md-button>
        <md-button type="submit" class="md-primary" :disabled="sending">Create</md-button>
      </md-card-actions>

    </md-card>

  </form>

</template>

<script>
 import axios from 'axios'

 var _vuelidate = require('vuelidate')
 var _validators = require('vuelidate/lib/validators')

 export default {
   mixins: [_vuelidate.validationMixin],
   data () {
     return {
       form: {
         first_name: null,
         last_name: null,
         email: null,
         password: null,
         password_confirmation: null
       },
       sending: false,
       server_errors: {
         email: {
           state: false,
           message: ''
         },
         password: {
           state: false,
           message: ''
         }
       }
     }
   },

   validations: {
     form: {
       first_name: {
         required: _validators.required
       },
       last_name: {
         required: _validators.required
       },
       email: {
         required: _validators.required,
         email: _validators.email
       },
       password: {
         required: _validators.required
       },
       password_confirmation: {
         required: _validators.required
       }
     }
   },

   methods: {

     getValidationClass (fieldName) {
       var field = this.$v.form[fieldName]

       var serverValidation = false
       if (this.server_errors[fieldName]) {
         serverValidation = this.server_errors[fieldName].state
       }

       if (field) {
         return {
           'md-invalid': (field.$invalid && field.$dirty) || serverValidation
         }
       }
     },

     validateUser () {
       this.$v.$touch()

       if (!this.$v.$invalid) {
         this.login()
       }
     },

     setupServerErrors () {
       this.server_errors = {
         email: {
           state: false,
           message: ''
         },
         password: {
           state: false,
           message: ''
         }
       }
     },

     login () {
       this.sending = true
       this.setupServerErrors()

       let params = {
         first_name: this.form.first_name,
         last_name: this.form.last_name,
         email: this.form.email,
         password: this.form.password,
         password_confirmation: this.form.password_confirmation
       }

       axios.post(this.$root.$options.api.url + 'api/register', params)
         .then((response) => {
           let params = {
             grant_type: 'password',
             username: this.form.email,
             password: this.form.password,
             scope: ''
           }

           axios.post(this.$root.$options.api.url + 'api/login', params)
             .then((response) => {
               if (response.data.response.error) {
                 this.login_error = true
                 this.sending = false
                 this.$router.push({name: 'login'})
               } else if (response.data.response.access_token) {
                 this.$root.$options.api.token = response.data.access_token
                 localStorage.setItem('token', response.data.access_token)
                 this.$router.push({name: 'matches'})
               }
             })
             .catch((error) => {
               this.sending = false
               console.log(error)
             })
         })
         .catch((error) => {
           this.sending = false

           if (error.response.data.errors.email) {
             this.server_errors.email.state = true
             this.server_errors.email.message = error.response.data.errors.email.join(',')
           }

           if (error.response.data.errors.password) {
             this.server_errors.password.state = true
             this.server_errors.password.message = error.response.data.errors.password.join(',')
           }
         })
     },

     beforeUpdate () {
       this.setupServerErrors()
     }

   }

 }
</script>
