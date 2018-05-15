<template>

  <div class="page-container">

    <md-app md-waterfall md-mode="fixed" style="height: 100vh;">

      <md-app-toolbar class="md-dense md-primary" v-if="userLoggedIn()">
        <div class="md-toolbar-row">
          <md-button class="md-icon-button" v-if="!onMatchDetail" @click="menuVisible = !menuVisible">
            <md-icon>menu</md-icon>
          </md-button>

          <md-button class="md-icon-button" v-if="onMatchDetail" @click="$router.push('/matches');">
            <md-icon>arrow_back</md-icon>
          </md-button>

          <span class="md-title">{{ title }}</span>
        </div>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible" v-if="userLoggedIn()">
        <md-toolbar class="md-primary" md-elevation="0"><span class="md-title">Predictor</span></md-toolbar>

        <md-list>

          <md-list-item @click="menuVisible = false; $router.push('/matches');">
            <md-icon>list</md-icon>
            <span class="md-list-item-text">Matches</span>
          </md-list-item>

          <md-list-item @click="menuVisible = false; $router.push('/predictions');">
            <md-icon>assignment</md-icon>
            <span class="md-list-item-text">Predictions</span>
          </md-list-item>

          <md-list-item @click="menuVisible = false; $router.push('/leaderboard');">
            <md-icon>grade</md-icon>
            <span class="md-list-item-text">Leaderboard</span>
          </md-list-item>

        </md-list>
      </md-app-drawer>

      <md-app-content v-bind:class="{ 'md-primary md-layout md-alignment-center-center': !userLoggedIn(), 'no-padding': userLoggedIn() }" class="">
        <keep-alive include="predictions">
          <router-view></router-view>
        </keep-alive>
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
       console.log('checklogin')
       if (this.$root.$options.api.token === null) {
         console.log('false')
         return false
       }

       console.log('true')
       return true
     },

     returnToMatchList () {
       this.$root.$options.showPredictionsList = false
       this.$forceUpdate()
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
 .text-right{
   text-align:right;
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
 .md-card.match-info {
   margin:0;
 }
 .md-card.match-info .md-card-header {
   padding:0;
 }
 .md-card.match-info .md-card-content {
   padding:0;
 }
</style>
