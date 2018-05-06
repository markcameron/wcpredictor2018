<template>

  <div>

    <md-toolbar :md-elevation="1">
      <span class="md-title">Login</span>
    </md-toolbar>

    <form novalidate class="md-layout" @submit.prevent="validateUser">

      <md-card class="md-layout-item md-size-50 md-small-size-100">

        <md-card-content>

          <div class="md-layout md-gutter">

            <md-field :class="getValidationClass('email')">
              <label for="email">Email</label>
              <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
              <span class="md-error" v-if="!$v.form.email.required">The email is required</span>
              <span class="md-error" v-else-if="!$v.form.email.email">Invalid email</span>
            </md-field>

            <md-field :class="getValidationClass('password')">
              <label for="password">Password</label>
              <md-input type="password" name="password" id="password" autocomplete="password" v-model="form.password" :disabled="sending" />
              <span class="md-error" v-if="!$v.form.password.required">The password is required</span>
            </md-field>

          </div>

        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Login</md-button>
        </md-card-actions>

      </md-card>

    </form>

  </div>

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
         email: null,
         password: null
       },
       sending: false
     }
   },

   validations: {
     form: {
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
         grant_type: 'password',
         client_id: 2,
         client_secret: 'T9U3i0LfXQd0Tyq0WHwRoOOmqsUTRr1MjSBjbwX8',
         username: this.form.email,
         password: this.form.password,
         scope: ''
       }

       axios.post(this.$root.$options.api.url + 'oauth/token', params)
         .then((response) => {
           this.$root.$options.api.token = response.data.access_token
           localStorage.setItem('token', response.data.access_token)
           this.$router.push({name: 'matches'})
         })
         .catch((error) => {
           this.sending = false
           console.log(error)
         })
     }

   }

 }
</script>
