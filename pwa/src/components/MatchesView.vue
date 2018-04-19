<template>

  <div>

    <ul class="demo-list-item mdl-list">
      <li v-for="match in this.getMatches()" class="mdl-list__item">
        <span class="mdl-list__item-primary-content">
          <span :class="'flag-icon-' + match.home_team_code" class="flex-media-figure flag-icon"></span>
          {{ match.home_team }} - {{ match.away_team }}
          <span :class="'flag-icon-' + match.away_team_code" class="flex-media-figure flag-icon"></span>
        </span>
      </li>
    </ul>

  </div>

</template>

<script>
 import axios from 'axios'

 export default {
   data () {
     return {
     }
   },

   methods: {

     getMatches () {
       if (navigator.onLine) {
         this.saveMatchesToCache()
         return JSON.parse(localStorage.getItem('matches'))
       } else {
         return JSON.parse(localStorage.getItem('matches'))
       }
     },

     saveMatchesToCache () {
       axios.get(this.$root.$options.api.url + 'api/matches/list', {
         headers: {
           Access: 'json',
           Authorization: 'Bearer ' + this.$root.$options.access_token
         }
       })
         .then((response) => {
           localStorage.setItem('matches', JSON.stringify(response.data))
         })
         .catch((error) => {
           console.log(error)
         })
     }

   },

   mounted () {
     this.getMatches()
   }
 }
</script>

<style scoped>
 .list {
   width: 100%;
   padding: 0;
 }
</style>
