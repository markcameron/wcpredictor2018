<template>

  <div class="page-container">

    <md-app md-waterfall md-mode="fixed" style="height: 100vh;">
      <md-app-toolbar class="md-dense md-primary">
        <div class="md-toolbar-row">
          <md-button class="md-icon-button" @click="menuVisible = !menuVisible">
            <md-icon>menu</md-icon>
          </md-button>

          <span class="md-title">{{ title }}</span>
        </div>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible">
        <md-toolbar class="md-primary" md-elevation="0"><span class="md-title">Predictor</span></md-toolbar>

        <md-list>

          <md-list-item @click="menuVisible = false; $router.push('/');">
            <md-icon>move_to_inbox</md-icon>
            <span class="md-list-item-text">Home</span>
          </md-list-item>

          <md-list-item @click="menuVisible = false; $router.push('/login');">
              <md-icon>send</md-icon>
              <span class="md-list-item-text">Login</span>
          </md-list-item>

          <md-list-item @click="menuVisible = false; $router.push('/matches');">
            <md-icon>move_to_inbox</md-icon>
            <span class="md-list-item-text">Matches</span>
          </md-list-item>

          <md-list-item @click="menuVisible = false; $router.push('/predictions');">
            <md-icon>send</md-icon>
            <span class="md-list-item-text">Predictions</span>
          </md-list-item>

        </md-list>
      </md-app-drawer>

      <md-app-content>
        <router-view></router-view>
      </md-app-content>

    </md-app>

  </div>

</template>

<script>
 export default {
   name: 'app',
   data: function () {
     return {
       menuVisible: false,
       title: ''
     }
   },
   methods: {
     userLoggedIn () {
       if (this.$root.$options.api.token === null) {
         return false
       }

       return true
     }
   },
   updated () {
     this.title = this.$route.meta.title
   },
   mounted () {
     console.log('mounted')
   }
 }
</script>

<style>
 @import url('https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300ita‌​lic,400italic,500,500italic,700,700italic,900italic,900');
 @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
 @import "../node_modules/flag-icon-css/css/flag-icon.css"
</style>
