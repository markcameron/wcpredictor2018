<template>

  <ul class="demo-list-item mdl-list">
    <li v-for="match in this.matches" class="mdl-list__item">
      <span class="mdl-list__item-primary-content">
        {{ match.home_team }} - {{ match.away_team }}
      </span>
    </li>
  </ul>

</template>

<script>
 import data from '../data'

 export default {
   data () {
     return {
       'matches': data.matches
     }
   }
 }
</script>

<style scoped>
 .list {
   width: 100%;
   padding: 0;
 }
</style>
