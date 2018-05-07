<template>

  <div>

    <md-card class="md-primary match-detail">
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
 export default {
   props: [
     'id'
   ],

   data () {
     return {
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
     }

   },

   mounted () {
     this.getMatch()
   }

 }
</script>
