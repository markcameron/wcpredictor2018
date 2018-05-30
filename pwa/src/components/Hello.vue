<template>
  <div class="hello">
    hello
  </div>
</template>

<script>
 export default {
   name: 'hello',
   data () {
     return {
       msg: 'Welcome to Your Vue.js PWA'
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
h1, h2 {
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
</style>
