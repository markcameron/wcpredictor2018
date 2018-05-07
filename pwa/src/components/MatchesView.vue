<template>

  <div>

    <md-list class="match-list" v-if="!show_predictions_list">

      <md-list-item v-for="match in this.matches" v-bind:key="match.id" @click="showMatchPredictions(match)">
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

    <md-card class="md-primary">
      <md-card-header>

      </md-card-header>

      <md-card-content>

        <md-list class="match-list" v-if="show_predictions_list">

          <md-list-item v-for="user in this.match.predictions" v-bind:key="match.id">
            <md-avatar class="md-avatar-icon md-primary">
              {{ user.initials }}
            </md-avatar>
            <span class="md-list-item-text">{{ user.name }}</span>
            <span class="md-list-item-text">{{ user.score_home }} - {{ user.score_away }}</span>
          </md-list-item>

        </md-list>
      </md-card-content>

    </md-card>

  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
       show_predictions_list: false,
       matches: null,
       match: null
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
             this.$root.$options.vars.matches = response.data
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

     showMatchPredictions (match) {
       this.match = match
       this.show_predictions_list = true
     }

   },

   mounted () {
     this.getMatches()
   }

 }
</script>
