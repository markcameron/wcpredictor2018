<template>

  <form novalidate class="md-layout md-alignment-center-center" @submit.prevent="validateUser">

    <md-card class="md-layout-item md-size-30 md-small-size-100">

      <md-card-header class="md-primary">
        <div class="md-title">
          World Cup 2018 Predictor
        </div>
      </md-card-header>

      <md-divider></md-divider>

      <md-card-content>
        <md-button class="fb-signin-button" :disabled="sending" @click="loginFacebook">
          Login with Facebook
          <md-progress-spinner md-mode="indeterminate" :md-diameter="15" :md-stroke="2" v-if="sending_facebook"></md-progress-spinner>
        </md-button>
        <span v-if="facebook_login_error" class="text-error">Error logging in with Facebook</span>
      </md-card-content>

      <md-divider></md-divider>

      <md-card-content>

        <div class="md-layout">

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

        <span v-if="login_error" class="text-error">Could not log you in with those credentials</span>
      </md-card-content>

      <md-divider></md-divider>
      <md-progress-bar md-mode="indeterminate" v-if="sending" />

      <md-card-actions>
        <md-button class="md-default" @click="$router.push({name: 'signup'})" :disabled="sending">Signup</md-button>
        <md-button type="submit" class="md-primary" :disabled="sending">Login</md-button>
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
         email: null,
         password: null
       },
       sending: false,
       sending_facebook: false,
       facebook_login_error: false,
       login_error: false,
       fbSignInParams: {
         scope: 'email,public_profile',
         return_scopes: true
       }
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
       this.login_error = false

       let params = {
         username: this.form.email,
         password: this.form.password,
         scope: ''
       }

       axios.post(this.$root.$options.api.url + 'api/login', params)
         .then((response) => {
           console.log(response)
           if (response.data.response.error) {
             this.login_error = true
             this.sending = false
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
     },

     loginFacebook () {
       this.sending = true
       this.sending_facebook = true
       this.facebook_login_error = false

       window.FB.login((response) => {
         console.log(response)
         this.sending = false
         this.sending_facebook = false
         if (response.status === 'not_authorized') {
           this.facebook_login_error = true
         } else if (response.status === 'connected') {
           axios.post(this.$root.$options.api.url + 'api/auth/social/facebook', response.authResponse)
             .then((response) => {
               this.$root.$options.api.token = response.data.original.response.access_token
               localStorage.setItem('token', response.data.original.response.access_token)
               this.$router.push({name: 'matches'})
             })
             .catch((error) => {
               this.sending = false
               this.facebook_login_error = true
               console.log(error)
             })
         } else {
           this.facebook_login_error = true
         }
       }, this.fbSignInParams)
     }

   }

 }
</script>

<style>
 .md-button.fb-signin-button,
 .md-button.fb-signin-button:disabled {
   /* This is where you control how the button looks. Be creative! */
   display: inline-block;
   padding: 4px 8px;
   border-radius: 3px;
   background-color: #4267b2;
   color: #fff;
 }
</style>
