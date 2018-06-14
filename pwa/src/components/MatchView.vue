<template>

  <div>

    <md-card class="md-primary match-info md-layout md-alignment-top-center" v-if="match">
      <md-card-header class="md-layout-item md-xlarge-size-33 md-large-size-33 md-medium-size-100">

        <md-list class="match-result-list md-theme-primary">

          <md-list-item>
            <md-icon :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></md-icon>
            <div class="md-list-item-text md-title">
              {{ match.home_team }}
            </div>
            <div class="md-list-item-text md-title prediction-value text-right">
              <span class="md-title">{{ match.score_home }}</span>
            </div>
          </md-list-item>

          <md-list-item>
            <md-icon :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></md-icon>
            <span class="md-list-item-text md-title">
              {{ match.away_team }}
            </span>
            <div class="md-list-item-text md-title prediction-value text-right">
              <span class="md-title">{{ match.score_away }}</span>
            </div>
          </md-list-item>

        </md-list>

      </md-card-header>
    </md-card>

    <md-card class="match-info md-layout md-alignment-top-center" v-if="match">
      <md-card-content class="md-layout-item md-xlarge-size-33 md-large-size-33 md-medium-size-100" v-if="!match.can_predict">

        <md-list class="match-list">

          <md-list-item v-for="user in match.predictions" v-bind:key="match.id">
            <md-avatar class="md-avatar-icon md-primary">
              {{ user.initials }}
            </md-avatar>
            <span class="md-list-item-text">{{ user.name }}</span>
            <div class="md-list-item-text text-right">
              <span class="md-title">{{ user.score_home }} - {{ user.score_away }}</span>
            </div>
            <div v-if="match.has_score" class="user-status">
              <md-icon class="exact-score" v-if="user.status === 'exact_score'">sentiment_very_satisfied</md-icon>
              <md-icon class="goal-difference" v-if="user.status === 'goal_difference'">sentiment_satisfied_alt</md-icon>
              <md-icon class="winner" v-if="user.status === 'winner'">sentiment_satisfied</md-icon>
              <md-icon class="loser" v-if="user.status === 'loser'">sentiment_very_dissatisfied</md-icon>
            </div>
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

<style>

 i.md-icon.md-theme-default.md-icon-font.exact-score {
   color:#24c280;
 }
 i.md-icon.md-theme-default.md-icon-font.goal-difference {
   color:#12afcb;
 }
 i.md-icon.md-theme-default.md-icon-font.winner {
 }
 i.md-icon.md-theme-default.md-icon-font.loser {
   color:#f25656;
 }
 .user-status .md-icon {
   margin-left:10px;
 }

</style>
