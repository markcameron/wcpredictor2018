<template>

  <div class="page-container">

    <md-app md-waterfall md-mode="fixed" style="height: 100vh;">

      <md-app-toolbar class="md-dense md-primary" v-if="userLoggedIn()">
        <div class="md-toolbar-row">
          <md-button class="md-icon-button" v-if="!onMatchDetail" @click="menuVisible = !menuVisible">
            <md-icon>menu</md-icon>
          </md-button>

          <md-button class="md-icon-button" v-if="onMatchDetail" @click="$router.push('/');">
            <md-icon>arrow_back</md-icon>
          </md-button>

          <span class="md-title">{{ title }}</span>
        </div>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible" v-if="userLoggedIn()">
        <md-toolbar class="md-primary" md-elevation="0"><span class="md-title">Predictor</span></md-toolbar>

        <md-list>

          <md-list-item to="/" @click="menuVisible = false;">
            <md-icon>list</md-icon>
            <span class="md-list-item-text">Matches</span>
          </md-list-item>

          <md-list-item to="/predictions" @click="menuVisible = false;">
            <md-icon>assignment</md-icon>
            <span class="md-list-item-text">Predictions</span>
          </md-list-item>

          <md-list-item to="/leaderboard" @click="menuVisible = false;">
            <md-icon>grade</md-icon>
            <span class="md-list-item-text">Leaderboard</span>
          </md-list-item>

          <md-list-item to="/rules" @click="menuVisible = false;">
            <md-icon>gavel</md-icon>
            <span class="md-list-item-text">Rules</span>
          </md-list-item>

          <md-list-item to="/settings" @click="menuVisible = false;">
            <md-icon>settings</md-icon>
            <span class="md-list-item-text">Settings</span>
          </md-list-item>

        </md-list>
      </md-app-drawer>

      <md-app-content v-bind:class="{ 'md-layout md-alignment-center-center': !userLoggedIn(), 'no-padding': userLoggedIn() }" class="">
        <div class="outer-container">
          <keep-alive include="predictions">
            <transition name="fade">
              <router-view></router-view>
            </transition>
          </keep-alive>
        </div>

        <md-bottom-bar
            slot="md-app-drawer"
            class="md-primary"
            style="position:fixed;bottom:0;z-index:100;"
            md-sync-route
            v-if="userLoggedIn()"
        >
          <md-bottom-bar-item to="/" md-label="Matches" md-icon="list"></md-bottom-bar-item>
          <md-bottom-bar-item to="/predictions" md-label="Predictions" md-icon="assignment"></md-bottom-bar-item>
          <md-bottom-bar-item to="/leaderboard" md-label="Leaderboard" md-icon="grade"></md-bottom-bar-item>
        </md-bottom-bar>
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
       onMatchDetail: false,
       title: ''
     }
   },

   methods: {
     userLoggedIn () {
       if (this.$root.$options.api.token === null) {
         return false
       }

       if (this.$root.$options.api.token === 'undefined') {
         return false
       }

       return true
     },

     returnToMatchList () {
       this.$root.$options.showPredictionsList = false
       this.$forceUpdate()
     },

     logout () {
       this.menuVisible = false

       window.FB.getLoginStatus((response) => {
         if (response && response.status === 'connected') {
           window.FB.logout((response) => {

           })
         }
       })

       this.$root.$options.api.token = null
       localStorage.removeItem('token')

       this.$router.push({name: 'login'})
     }
   },

   updated () {
     this.title = this.$route.meta.title
     this.onMatchDetail = this.$root.$options.onMatchDetail
   },

   mounted () {
     if (!this.userLoggedIn()) {
       this.$router.push({name: 'login'})
     }

     if (this.userLoggedIn() && this.$router.currentRoute.name === 'login') {
       this.$router.push({name: 'matches'})
     }

     this.title = this.$route.meta.title
   }
 }
</script>

<style>
 @import url('https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300ita‌​lic,400italic,500,500italic,700,700italic,900italic,900');
 @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
 @import "../node_modules/flag-icon-css/css/flag-icon.css"
</style>

<style>
 .text-uppercase {
   text-transform:uppercase;
 }
 .text-center {
   text-align:center;
 }
 .text-right {
   text-align:right;
 }
 .text-error {
   color:red;
 }
 .md-app-content.no-padding {
   padding: 0;
 }
 .match-list .md-list-item-content>.md-icon:first-child {
   margin-right: 16px;
 }
 .md-list-item-content>.md-icon:nth-last-child(2) {
   margin-left: 16px;
 }
 .md-app-content .md-card.prediction {
   margin: 0;
   overflow: visible;
 }
 .md-app-content .md-card {
   margin-right: 0px;
 }
 .md-app-content .md-card.match-info {
   margin:0;
 }
 .md-card.match-info .md-card-header {
   padding:0;
 }
 .md-card.match-info .md-card-content {
   padding:0;
 }

 .fade-enter-active, .fade-leave-active {
   transition-property: opacity;
   transition-duration: .125s;
 }
 .fade-enter-active {
   transition-delay: 0;
 }
 .fade-enter, .fade-leave-active {
   opacity: 0
 }
 .outer-container {
   padding-bottom:50px;
 }
</style>
