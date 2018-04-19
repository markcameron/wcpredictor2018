import Vue from 'vue'
import Router from 'vue-router'
import LoginView from '@/components/LoginView'
import MatchesView from '@/components/MatchesView'
import PredictionsView from '@/components/PredictionsView'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'matches',
      component: LoginView
    },
    {
      path: '/matches',
      name: 'matches',
      component: MatchesView
    },
    {
      path: '/predictions',
      name: 'predictions',
      component: PredictionsView
    }
  ]
})
