import Vue from 'vue'
import Router from 'vue-router'
import MatchesView from '@/components/MatchesView'
import PredictionsView from '@/components/PredictionsView'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
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
