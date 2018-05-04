import Vue from 'vue'
import Router from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.css'
import 'vue-material/dist/theme/default.css'
import HelloView from '@/components/Hello'
import LoginView from '@/components/LoginView'
import MatchesView from '@/components/MatchesView'
import PredictionsView from '@/components/PredictionsView'
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
      component: LoginView
    },
    {
      path: '/matches',
      name: 'matches',
      component: MatchesView,
      meta: {
        requires_auth: true
      }
    },
    {
      path: '/predictions',
      name: 'predictions',
      component: PredictionsView,
      meta: {
        requires_auth: true
      }
    }
  ]
})
