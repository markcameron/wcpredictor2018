<template>

  <md-list class="match-list">

    <md-list-item v-for="match in this.predictions" v-bind:key="match.id">
      <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
      <div class="md-list-item-text">{{ match.home_team }}</div>
      <div v-if="!canPredict(match)" class="md-list-item-text text-center">
        <span class="md-title" v-if="hasPrediction(match)">{{ match.score_home }} - {{ match.score_away }}</span>
        <span class="md-title" v-if="!hasPrediction(match)">¯\_(ツ)_/¯</span>
      </div>
      <div v-if="canPredict(match)" class="md-list-item-text md-alignment-center-center">
        <md-button class="md-primary">Add</md-button>
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
       predictions: null
     }
   },

   methods: {

     getPredictions () {
       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/predictions/list', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.predictions = response.data
             localStorage.setItem('predictions', JSON.stringify(response.data))
           })
           .catch((error) => {
             console.log(error)
           })
       } else {
         return JSON.parse(localStorage.getItem('predictions'))
       }
     },

     canPredict (match) {
       var hasScore = match.score_home != null && match.score_away != null

       if (hasScore) {
         return false
       }

       if (match.can_predict === 1) {
         return true
       }

       return false
     },

     hasPrediction (match) {
       if (match.score_home != null && match.score_away != null) {
         return true
       }

       return false
     }

   },

   mounted () {
     this.getPredictions()
   }

 }
</script>

<style scoped>
 .list {
   width: 100%;
   padding: 0;
 }
</style>
