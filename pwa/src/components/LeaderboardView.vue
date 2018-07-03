<template>

  <div class="md-layout md-alignment-top-center">

    <md-list class="match-list md-layout-item md-xlarge-size-33 md-large-size-33 md-medium-size-100">

      <md-list-item v-for="(user, index) in this.leaderboard" v-bind:key="index">
        <md-avatar class="md-avatar-icon md-primary">
          {{ user.initials }}
        </md-avatar>
        <div class="md-list-item-text counter">
          {{ index + 1 }}.
        </div>
        <div class="md-list-item-text md-layout-item md-size-55">
          <span v-if="user.nickname"><b>{{ user.nickname }}</b></span>
          <span v-if="!user.nickname"><b>{{ user.full_name }}</b></span>
          <span>{{ user.catchphrase }}</span>
          <span v-if="user.nickname">{{ user.full_name }}</span>
        </div>
        <div class="md-list-item-text text-right md-layout-item md-size-15">
          <span class="md-title">{{ user.score }}</span>
        </div>
      </md-list-item>

    </md-list>

  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
       leaderboard: null
     }
   },

   methods: {

     getLeaderboard () {
       this.leaderboard = JSON.parse(localStorage.getItem('leaderboard'))

       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/leaderboard', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.leaderboard = response.data
             localStorage.setItem('leaderboard', JSON.stringify(response.data))
           })
           .catch((error) => {
             console.log(error)
           })
       }
     }

   },

   mounted () {
     this.getLeaderboard()
   }

 }
</script>

<style>
 .counter {
   min-width:35px;
   max-width:35px;
 }
</style>
