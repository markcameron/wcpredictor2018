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
    url: 'https://wc2018.local:8443/',
    token: null
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
  console.log('before each route')
  if (!to.meta.requires_auth) {
    next()
  } else if (!user.check()) {
    next('/login')
  } else {
    next()
  }
})
