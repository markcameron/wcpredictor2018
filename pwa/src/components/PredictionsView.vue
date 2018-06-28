<template>

  <div>

    <div class="md-layout md-alignment-top-center" v-if="!show_match_card">

      <md-list class="match-list md-layout-item md-xlarge-size-33 md-large-size-50 md-medium-size-100">

        <md-list-item v-for="(match, index) in this.predictions" v-bind:key="index" @click="predictMatch(match)">
          <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
          <div class="md-list-item-text">{{ match.home_team }}</div>
          <div v-if="!canPredict(match)" class="md-list-item-text text-center">
            <span class="md-title" v-if="hasPrediction(match)">{{ match.score_home }} - {{ match.score_away }}</span>
            <span class="md-title" v-if="!hasPrediction(match)">¯\_(ツ)_/¯</span>
          </div>
          <div v-if="canPredict(match)" class="md-list-item-text text-center text-uppercase">
            <span class="md-primary">ADD</span>
          </div>
          <div class="md-list-item-text text-right">
            <span>{{ match.away_team }}</span>
          </div>
          <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
        </md-list-item>

      </md-list>

      <md-snackbar :md-position="position" :md-duration="isInfinity ? Infinity : duration" :md-active.sync="showSnackbar" md-persistent>
        <span>You can no longer predict scores for this match</span>
        <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
      </md-snackbar>

    </div>

    <div class="md-layout md-alignment-top-center" v-if="show_match_card">

      <md-card class="prediction md-layout-item md-xlarge-size-33 md-large-size-33 md-medium-size-100">

        <md-card-header class="md-primary">
          <div class="md-title">
            Enter your prediction for
          </div>
        </md-card-header>

        <md-card-content>
          <md-list class="match-list">

            <md-list-item>
              <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
              <div class="md-list-item-text md-title">
                {{ match.home_team }}
              </div>
              <md-button class="md-icon-button" @click="decreaseScore('home')">
                <md-icon>remove</md-icon>
              </md-button>
              <div class="md-list-item-text md-title prediction-value text-center">
                {{ score_home }}
              </div>
              <md-button class="md-icon-button" @click="increaseScore('home')">
                <md-icon>add</md-icon>
              </md-button>
            </md-list-item>

            <md-list-item>
              <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
              <span class="md-list-item-text md-title">
                {{ match.away_team }}
              </span>
              <md-button class="md-icon-button" @click="decreaseScore('away')">
                <md-icon>remove</md-icon>
              </md-button>
              <div class="md-list-item-text md-title prediction-value text-center">
                {{ score_away }}
              </div>
              <md-button class="md-icon-button" @click="increaseScore('away')">
                <md-icon>add</md-icon>
              </md-button>
            </md-list-item>

          </md-list>
        </md-card-content>

        <md-divider></md-divider>
        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button @click="cancelScore" :disabled="sending">Cancel</md-button>
          <md-button class="md-primary md-raised" @click="saveScore()" :disabled="sending">Save</md-button>
        </md-card-actions>

      </md-card>
      <md-snackbar :md-position="position" :md-duration="isInfinity ? Infinity : duration" :md-active.sync="showSnackbar" md-persistent>
        <span>You can no longer predict scores for this match</span>
        <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
      </md-snackbar>

    </div>

  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
       predictions: null,
       show_match_card: false,
       sending: false,
       match: false,
       score_home: null,
       score_away: null,
       showSnackbar: false,
       position: 'center',
       duration: 4000,
       isInfinity: false
     }
   },

   methods: {

     getPredictions () {
       this.predictions = JSON.parse(localStorage.getItem('predictions'))

       if (navigator.onLine) {
         axios.get(this.$root.$options.api.url + 'api/predictions/list', {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.predictions = response.data
             this.$root.$options.vars.predictions = response.data
             localStorage.setItem('predictions', JSON.stringify(response.data))
           })
           .catch((error) => {
             console.log(error)
           })
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
     },

     predictMatch (match) {
       if (match.can_predict) {
         this.match = match
         this.show_match_card = true
         this.score_home = match.score_home || 0
         this.score_away = match.score_away || 0
       } else {
         this.showSnackbar = true
       }
     },

     increaseScore (type) {
       if (this.$data['score_' + type] >= 20) {
         this.$data['score_' + type] = 20
       } else {
         this.$data['score_' + type]++
       }
     },

     decreaseScore (type) {
       if (this.$data['score_' + type] <= 0) {
         this.$data['score_' + type] = 0
       } else {
         this.$data['score_' + type]--
       }
     },

     cancelScore () {
       this.show_match_card = false
     },

     saveScore () {
       this.sending = true

       if (navigator.onLine) {
         axios.put(this.$root.$options.api.url + 'api/predictions/' + this.match.id, {
           score_home: this.score_home,
           score_away: this.score_away
         },
         {
           headers: {
             Access: 'json',
             Authorization: 'Bearer ' + this.$root.$options.api.token
           }
         })
           .then((response) => {
             this.match.score_home = response.data.prediction.score_home
             this.match.score_away = response.data.prediction.score_away
             this.show_match_card = false
             this.sending = false
           })
           .catch((error) => {
             this.sending = false
             this.showSnackbar = true
             console.log(error)
           })
       } else {
         return JSON.parse(localStorage.getItem('predictions'))
       }
     }

   },

   mounted () {
     if (this.predictions === null) {
       this.getPredictions()
     }
   }

 }
</script>

<style scoped>
 .prediction-value {
   max-width:30px;
   display:block;
 }
</style>
