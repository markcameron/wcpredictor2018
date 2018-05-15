// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import user from './services/auth'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  api: {
    url: 'http://wc2018.local/',
    token: localStorage.getItem('token')
  },
  vars: {
    title: '',
    matches: null,
    predictions: null,
    onMatchDetail: false,
    showPredictionsList: false
  },
  router,
  template: '<App/>',
  components: { App }
})

router.beforeEach((to, from, next) => {
  if (!to.meta.requires_auth) {
    next()
  } else if (!user.check()) {
    next('/login')
  } else {
    next()
  }
})
