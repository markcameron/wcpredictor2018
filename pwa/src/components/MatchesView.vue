<template>

  <div class="md-layout md-alignment-top-center">

    <md-list class="match-list md-layout-item md-xlarge-size-33 md-large-size-50 md-medium-size-100">

      <md-subheader v-if="todays_matches">Today</md-subheader>

      <md-list-item v-if="todays_matches" v-for="match, index in this.todays_matches" v-bind:key="match.id" @click="showMatchPredictions(index)">
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

      <md-divider v-if="todays_matches" style="margin:15px 0 5px;"></md-divider>

      <md-subheader v-if="todays_matches">All</md-subheader>

      <md-list-item v-for="match, index in this.matches" v-bind:key="match.id" @click="showMatchPredictions(index)">
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

  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
       matches: null,
       match: null,
       todays_matches: []
     }
   },

   methods: {

     getMatches () {
       this.matches = JSON.parse(localStorage.getItem('matches'))
       this.todays_matches = this.parseTodaysMatches()

       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/matches/list', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.matches = response.data
             this.$root.$options.vars.matches = response.data
             localStorage.setItem('matches', JSON.stringify(response.data))
             this.todays_matches = this.parseTodaysMatches()
           })
           .catch((error) => {
             console.log(error)
           })
       }
     },

     parseTodaysMatches () {
       let todaysMatches = {}
       var today = new Date()

       this.matches.map((match, key) => {
         let matchDate = new Date(match.date)
         if (matchDate.toDateString() === today.toDateString()) {
           todaysMatches[key] = match
         }
       })

       return Object.keys(todaysMatches).length ? todaysMatches : null
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

     showMatchPredictions (match) {
       this.$router.push({name: 'match', params: {id: match}})
     },

     removeClass () {
       var elems = document.querySelectorAll('.match-result-list')

       Array.prototype.map.call(elems, el => {
         el.classList.remove('md-theme-default')
       })
     }

   },

   mounted () {
     this.$root.$options.onMatchDetail = false
     this.getMatches()
   },

   updated () {
     this.removeClass()
   }

 }
</script>
