'use strict'

const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  API_BASE_URL: '"https://wc2018.local:8443/"',
  BASE_URL: '"https://localhost:8088/"'
})
