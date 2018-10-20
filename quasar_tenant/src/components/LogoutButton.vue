<template>
  <q-btn
    q-sm
    round

    color="negative"
    @click="logout"
    icon="exit_to_app"
  />
</template>

<script>
export default {
  data () {
    return {

    }
  },
  
  methods: {
    logout() {
      this.$store.dispatch('auth/actUserLogout');
      this.$router.push('/login');
    }
  }
}
</script>

<style scoped>
</style>