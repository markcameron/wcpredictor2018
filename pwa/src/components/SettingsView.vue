<template>

  <form novalidate class="md-layout md-alignment-center-center" @submit.prevent="validateSettings">

    <div class="md-layout-item md-size-30 md-small-size-100 settings">

      <div class="md-layout">

        <md-field :class="getValidationClass('catchphrase')">
          <label for="catchphrase">Catchphrase</label>
          <md-input type="text" name="catchphrase" id="catchphrase" autocomplete="catchphrase" v-model="form.catchphrase" :disabled="sending" />
          <span class="md-error" v-if="!$v.form.catchphrase.required">Your first name is required</span>
        </md-field>

        <md-field :class="getValidationClass('nickname')">
          <label for="last-name">Nickname</label>
          <md-input type="text" name="nickname" id="last-name" autocomplete="nickname" v-model="form.nickname" :disabled="sending" />
          <span class="md-error" v-if="!$v.form.nickname.required">Your nickname is required</span>
        </md-field>

      </div>

      <md-divider></md-divider>
      <md-progress-bar md-mode="indeterminate" v-if="sending" />

      <md-card-actions>
        <md-button type="submit" class="md-primary" :disabled="sending">Save</md-button>
      </md-card-actions>

    </div>

  </form>

</template>

<script>
 import axios from 'axios'

 var _vuelidate = require('vuelidate')
 // var _validators = require('vuelidate/lib/validators')

 export default {
   mixins: [_vuelidate.validationMixin],
   data () {
     return {
       form: {
         catchphrase: null,
         nickname: null
       },
       sending: false
     }
   },

   validations: {
     form: {
       catchphrase: {
       },
       nickname: {
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

     validateSettings () {
       this.$v.$touch()

       if (!this.$v.$invalid) {
         this.saveSettings()
       }
     },

     getSettings () {
       this.form.catchphrase = localStorage.getItem('settings.catchphrase')
       this.form.nickname = localStorage.getItem('settings.nickname')

       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/settings', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.sending = false
             this.form.nickname = response.data.nickname
             this.form.catchphrase = response.data.catchphrase
             localStorage.setItem('settings.catchphrase', response.data.catchphrase)
             localStorage.setItem('settings.nickname', response.data.nickname)
           })
           .catch((error) => {
             this.sending = false
             console.log(error)
           })
       }
     },

     saveSettings () {
       this.sending = true

       let params = {
         nickname: this.form.nickname,
         catchphrase: this.form.catchphrase
       }

       axios.post(this.$root.$options.api.url + 'api/settings', params, {
         headers: {
           Access: 'json',
           Authorization: 'Bearer ' + this.$root.$options.api.token
         }
       })
         .then((response) => {
           this.sending = false
           this.form.nickname = response.data.nickname
           this.form.catchphrase = response.data.catchphrase
           localStorage.setItem('settings.catchphrase', response.data.catchphrase)
           localStorage.setItem('settings.nickname', response.data.nickname)
         })
         .catch((error) => {
           this.sending = false
           console.log(error)
         })
     }

   },

   mounted () {
     this.getSettings()
   }

 }
</script>

<style>
 .md-layout-item.settings {
   padding:16px;
 }
</style>
