<template>

  <md-card class="prediction" v-if="match">

    <md-card-header class="md-primary">
      <div class="md-title">
        <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
        {{ match.home_team }}
      </div>
      <div class="md-title">
        <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
        {{ match.away_team }}
      </div>
    </md-card-header>

    <md-card-content>
      <md-list class="match-list">

        <md-list-item>
          <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
          <div class="md-list-item-text">{{ match.home_team }}</div>
          <md-button class="md-icon-button" @click="decreaseScore('home')">
            <md-icon>remove</md-icon>
          </md-button>
          <div class="md-list-item-text">
            {{ score_home }}
          </div>
          <md-button class="md-icon-button" @click="increaseScore('home')">
            <md-icon>add</md-icon>
          </md-button>
        </md-list-item>
        <md-list-item>
          <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
          <span class="md-list-item-text">
            {{ match.away_team }}
          </span>
          <md-button class="md-icon-button" @click="decreaseScore('away')">
            <md-icon>remove</md-icon>
          </md-button>
          <div class="md-list-item-text">
            {{ score_away }}
          </div>
          <md-button class="md-icon-button" @click="increaseScore('away')">
            <md-icon>add</md-icon>
          </md-button>
        </md-list-item>

      </md-list>
    </md-card-content>

    <md-card-actions>
      <md-button to="/predictions">Cancel</md-button>
      <md-button class="md-primary">Save</md-button>
    </md-card-actions>

  </md-card>

</template>

<script>
 export default {
   props: [
     'id'
   ],
   data () {
     return {
       match: null,
       score_home: null,
       score_away: null
     }
   },

   methods: {

     getMatch () {
       if (this.$root.$options.vars.predictions === null) {
         this.$router.push({name: 'predictions'})
       } else {
         this.match = this.$root.$options.vars.predictions[this.id]
         this.score_home = this.match.score_home
         this.score_away = this.match.score_away
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
     }

   },

   beforeMount () {
     this.getMatch()
   }

 }
</script>
