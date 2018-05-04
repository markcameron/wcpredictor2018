<template>

  <div>

    <ul class="demo-list-item mdl-list">
      <li v-for="prediction in this.getPredictions()" class="mdl-list__item">
        <span class="mdl-list__item-primary-content">
          <span :class="'flag-icon-' + prediction.home_team_code" class="flex-media-figure flag-icon"></span>
          {{ prediction.home_team }} - {{ prediction.away_team }}
          <span :class="'flag-icon-' + prediction.away_team_code" class="flex-media-figure flag-icon"></span>
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

     getPredictions () {
       if (navigator.onLine) {
         this.savePredictionsToCache()
         return JSON.parse(localStorage.getItem('predictions'))
       } else {
         return JSON.parse(localStorage.getItem('predictions'))
       }
     },

     savePredictionsToCache () {
       axios.get(this.$root.$options.api.url + 'api/predictions/list')
         .then((response) => {
           localStorage.setItem('predictions', JSON.stringify(response.data))
         })
         .catch((error) => {
           console.log(error)
         })
     }

   },

   mounted () {
     //     this.getPredictions()
   }
 }
</script>

<style scoped>
 .list {
   width: 100%;
   padding: 0;
 }
</style>
