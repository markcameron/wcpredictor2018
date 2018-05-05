export default {
  user () {
    return this.$store.state.user
  },

  check () {
    console.log('in check: ' + localStorage.getItem('token'))
    return localStorage.getItem('token')
  }
}
