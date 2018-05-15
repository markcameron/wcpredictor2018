<template>

  <div>

    <md-card class="md-primary match-info" v-if="match">
      <md-card-header>

        <md-list class="match-result-list md-theme-primary">

          <md-list-item>
            <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
            <div class="md-list-item-text md-title">
              {{ match.home_team }}
            </div>
            <div class="md-list-item-text md-title prediction-value text-center">
              {{ match.score_home }}
            </div>
          </md-list-item>

          <md-list-item>
            <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
            <span class="md-list-item-text md-title">
              {{ match.away_team }}
            </span>
            <div class="md-list-item-text md-title prediction-value text-center">
              {{ match.score_away }}
            </div>
          </md-list-item>

        </md-list>

      </md-card-header>

      <md-card-content>

        <md-list class="match-list">

          <md-list-item v-for="user in match.predictions" v-bind:key="match.id">
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
 export default {
   props: [
     'id'
   ],

   data () {
     return {
       show_predictions_list: false,
       match: null
     }
   },

   methods: {

     getMatch () {
       if (this.$root.$options.vars.matches === null) {
         this.$router.push({name: 'matches'})
       } else {
         this.match = this.$root.$options.vars.matches[this.id]
       }
     },

     removeClass () {
       var elems = document.querySelectorAll('.match-result-list')

       Array.prototype.map.call(elems, el => {
         el.classList.remove('md-theme-default')
       })
     }

   },

   mounted () {
     this.$root.$options.onMatchDetail = true
     this.getMatch()
   },

   updated () {
     this.removeClass()
   }

 }
</script>
