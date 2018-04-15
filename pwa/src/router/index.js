import Vue from 'vue'
import Router from 'vue-router'
import MatchesView from '@/components/MatchesView'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'matches',
      component: MatchesView
    }
  ]
})
