<template>

  <div class="mdl-layout mdl-js-layout mdl-color--grey-100">
    <main class="mdl-layout__content">
      <div class="mdl-card mdl-shadow--6dp">
        <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
          <h2 class="mdl-card__title-text">Login</h2>
        </div>
        <div class="mdl-card__supporting-text">
          <form action="#">
            <div class="mdl-textfield mdl-js-textfield">
              <input v-model="email" class="mdl-textfield__input" type="text" id="email" />
              <label class="mdl-textfield__label" for="email">E-mail</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <input v-model="password" class="mdl-textfield__input" type="password" id="userpass" />
              <label class="mdl-textfield__label" for="userpass">Password</label>
            </div>
          </form>
        </div>
        <div class="mdl-card__actions mdl-card--border">
          <button v-on:click="login" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Log in</button>
        </div>
      </div>
    </main>
  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
     }
   },

   methods: {

     login () {
       let params = {
         grant_type: 'password',
         client_id: 2,
         client_secret: 'T9U3i0LfXQd0Tyq0WHwRoOOmqsUTRr1MjSBjbwX8',
         username: this.email,
         password: this.password,
         scope: ''
       }
       axios.post(this.$root.$options.api.url + 'oauth/token', params)
         .then((response) => {
           this.$root.$options.access_token = response.data.access_token
           this.$router.push({path: 'matches'})
         })
         .catch((error) => {
           console.log(error)
         })
     }

   }

 }
</script>

<style scoped>
 .mdl-layout {
   align-items: center;
   justify-content: center;
 }
 .mdl-layout__content {
   padding: 24px;
   flex: none;
 }
</style>
