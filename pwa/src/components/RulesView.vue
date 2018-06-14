<template>

  <div class="md-layout md-alignment-top-center">

    <div class="rules-container md-layout-item md-xlarge-size-33 md-large-size-50 md-medium-size-100">

      <h2>Predictions</h2>
      <p>For all group stage predictions, you must have predicted all results by kick off of the first game (June 14th, 1700 CET).</p>
      <p>For the knockout round, predictions need only be in by kick off of the game in question.</p>

      <h2>Scoring</h2>
      The break down of points awarded is as follows:

      <ul style="margin-top:0;">
        <li>
          <h3>5 points</h3>
          <p>For guessing the exact score and result of a match</p>
        </li>
        <li>
          <h3>3 points</h3>
          <p>For guessing the exact goal difference and result of a match</p>
        </li>
        <li>
          <h3>2 point</h3>
          <p>For guessing the correct winner of a match</p>
        </li>
      </ul>

    </div>

  </div>

</template>

<script>
 export default {
   data () {
     return {
     }
   },

   methods: {

     updated () {
       console.log('updated')
     },

     mounted () {
       console.log('mounted')
     }

   }
 }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
 h1 {
   font-weight: normal;
 }

 ul {
   list-style-type: none;
   padding: 0;
 }

 li {
   display: inline-block;
   margin: 0 10px;
 }

 a {
   color: #35495E;
 }

 .rules-container {
   padding:15px;
 }
</style>
