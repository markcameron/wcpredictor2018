import Vue from 'vue'
import Router from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.css'
import 'vue-material/dist/theme/default.css'
import LoginView from '@/components/LoginView'
import SignupView from '@/components/SignupView'
import MatchView from '@/components/MatchView'
import MatchesView from '@/components/MatchesView'
import PredictionsView from '@/components/PredictionsView'
import LeaderboardView from '@/components/LeaderboardView'
import SettingsView from '@/components/SettingsView'
import RulesView from '@/components/RulesView'
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
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        title: 'Login'
      }
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignupView,
      meta: {
        title: 'Signup'
      }
    },
    {
      path: '/',
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
    },
    {
      path: '/settings',
      name: 'settings',
      component: SettingsView,
      meta: {
        title: 'Settings',
        requires_auth: true
      }
    },
    {
      path: '/rules',
      name: 'rules',
      component: RulesView,
      meta: {
        title: 'Rules',
        requires_auth: true
      }
    }
  ]
})
