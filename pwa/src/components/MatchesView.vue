<template>

  <md-list class="match-list">

    <md-list-item v-for="match in this.matches" v-bind:key="match.id">
      <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
      <div class="md-list-item-text">{{ match.home_team }}</div>
      <div v-if="!hasResult(match)" class="md-list-item-text text-uppercase text-center">
        <span class="md-body-2">{{ match.date | formatDate }}</span>
        <span class="md-title">{{ match.date | formatTime }}</span>
      </div>
      <div v-if="hasResult(match)" class="md-list-item-text text-center">
        <span class="md-title">{{ match.score_home }} - {{ match.score_away }}</span>
      </div>
      <div class="md-list-item-text text-right">
        <span>{{ match.away_team }}</span>
      </div>
      <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
    </md-list-item>

  </md-list>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
       matches: null
     }
   },

   methods: {

     getMatches () {
       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/matches/list', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             console.log(response.data)
             this.matches = response.data
             localStorage.setItem('matches', JSON.stringify(response.data))
           })
           .catch((error) => {
             console.log(error)
           })
       } else {
         this.matches = JSON.parse(localStorage.getItem('matches'))
       }
     },

     hasResult (match) {
       var hasScore = match.score_home != null && match.score_away != null

       if (match.can_predict === 0 && hasScore) {
         return true
       }

       if (hasScore) {
         return true
       }

       return false
     },

     validateLogin () {
       console.log('validateLogin')
       console.log(this.$root.$options)
       if (!this.$root.$options.api.token) {
         this.$router.push({name: 'login'})
         return false
       }

       return true
     }

   },

   mounted () {
     if (this.validateLogin()) {
       this.getMatches()
     }
   }

 }
</script>

<style>
 .text-uppercase {
   text-transform:uppercase;
 }
 .text-center {
   text-align:center;
 }
 .text-right{
   text-align:right;
 }
 .match-list .md-list-item-content {
   padding:4px 0;
 }
 .match-list .md-list-item-content>.md-icon:first-child {
   margin-right: 16px;
 }
</style>
