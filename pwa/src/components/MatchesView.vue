<template>

  <div class="md-layout md-alignment-top-center">

    <md-list class="match-list md-layout-item md-large-size-50 md-medium-size-100">

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
       match: null
     }
   },

   methods: {

     getMatches () {
       this.matches = JSON.parse(localStorage.getItem('matches'))

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
           })
           .catch((error) => {
             console.log(error)
           })
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
