<template>

  <form novalidate class="md-layout" @submit.prevent="validateUser">

    <md-card class="md-layout-item md-size-50 md-small-size-100">

      <md-card-header class="md-primary">
        <div class="md-title">
          Create an account
        </div>
      </md-card-header>

      <md-divider></md-divider>

      <md-card-content>

        <div class="md-layout md-gutter">

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
            <label for="email">Email</label>
            <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.email.required">The email is required</span>
            <span class="md-error" v-else-if="!$v.form.email.email">Invalid email</span>
            <span class="md-error" v-else-if="$v.form.email.server_error">{{ $v.form.email.server_error }}</span>
          </md-field>

          <md-field :class="getValidationClass('password')">
            <label for="password">Password</label>
            <md-input type="password" name="password" id="password" autocomplete="password" v-model="form.password" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.password.required">The password is required</span>
          </md-field>

        </div>

      </md-card-content>

      <md-divider></md-divider>
      <md-progress-bar md-mode="indeterminate" v-if="sending" />

      <md-card-actions>
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
         password: null
       },
       sending: false
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
       }
     }
   },

   methods: {

     getValidationClass (fieldName) {
       var field = this.$v.form[fieldName]

       if (field) {
         return {
           'md-invalid': field.$invalid && field.$dirty
         }
       }
     },

     validateUser () {
       this.$v.$touch()

       if (!this.$v.$invalid) {
         this.login()
       }
     },

     login () {
       this.sending = true

       let params = {
         first_name: this.form.first_name,
         last_name: this.form.last_name,
         email: this.form.email,
         password: this.form.password
       }

       axios.post(this.$root.$options.api.url + 'api/register', params)
         .then((response) => {
           console.log(response)
           //           this.$root.$options.api.token = response.data.access_token
           //           localStorage.setItem('token', response.data.access_token)
           //           this.$router.push({name: 'matches'})
         })
         .catch((error) => {
           console.log('error register')
           this.sending = false

           console.log(error.response.data.errors)

           if (error.response.data.errors.email) {
             console.log('email error')
             this.$v.form.email.server_error = error.response.data.errors.email.join(',')
             console.log(this.$v.form.email.server_error)
           }
         })
     }

   }

 }
</script>
