<template>

  <md-list class="match-list">

    <md-list-item v-for="(user, index) in this.leaderboard" v-bind:key="index">
      <md-avatar class="md-avatar-icon md-primary">
        {{ user.initials }}
      </md-avatar>
      <div class="md-list-item-text">
        <span>{{ user.full_name }}</span>
        <span>Hopp Schwiiz</span>
      </div>
      <div class="md-list-item-text text-right">
        <span class="md-title">{{ user.score }}</span>
      </div>
    </md-list-item>

  </md-list>

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
       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/leaderboard', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             console.log(response.data)
             this.leaderboard = response.data
             localStorage.setItem('leaderboard', JSON.stringify(response.data))
           })
           .catch((error) => {
             console.log(error)
           })
       } else {
         this.matches = JSON.parse(localStorage.getItem('leaderboard'))
       }
     }

   },

   mounted () {
     this.getLeaderboard()
   }

 }
</script>
