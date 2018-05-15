import Vue from 'vue'
import Router from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.css'
import 'vue-material/dist/theme/default.css'
import HelloView from '@/components/Hello'
import LoginView from '@/components/LoginView'
import MatchView from '@/components/MatchView'
import MatchesView from '@/components/MatchesView'
import PredictionsView from '@/components/PredictionsView'
import LeaderboardView from '@/components/LeaderboardView'
import moment from 'moment'

Vue.use(Router)
Vue.use(VueMaterial)

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('MMM D')
  }
})

Vue.filter('formatTime', function (value) {
  if (value) {
    return moment(String(value)).format('kk:mm')
  }
})

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: HelloView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        title: 'Login'
      }
    },
    {
      path: '/matches',
      name: 'matches',
      component: MatchesView,
      meta: {
        title: 'Matches',
        requires_auth: true
      }
    },
    {
      path: '/match/:id',
      name: 'match',
      component: MatchView,
      props: true,
      meta: {
        title: 'Match',
        requires_auth: true
      }
    },
    {
      path: '/predictions',
      name: 'predictions',
      component: PredictionsView,
      meta: {
        title: 'Predictions',
        requires_auth: true
      }
    },
    {
      path: '/leaderboard',
      name: 'leaderboard',
      component: LeaderboardView,
      meta: {
        title: 'Leaderboard',
        requires_auth: true
      }
    }
  ]
})
