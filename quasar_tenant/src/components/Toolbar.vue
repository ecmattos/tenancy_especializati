<template>
  <q-toolbar
    color="primary"
    :glossy="$q.theme === 'mat'"
    :inverted="$q.theme === 'ios'"
  >
    <q-btn
      v-if="checkIfUserLogged"
      flat
      dense
      round
      @click="$root.$emit('toggle_left_drawer')"
      aria-label="Menu"
    >
      <q-icon name="menu" />
    </q-btn>

    <q-toolbar-title>
      {{ pageTitle }}
      <div slot="subtitle">{{ pageSubTitle }}</div>
    </q-toolbar-title>
        
    <div v-if="$q.platform.is.desktop">
      <q-btn :icon="(fullScreen ? 'fullscreen_exit' : 'fullscreen')" flat @click="toggleFullScreen()"></q-btn>
    </div>
  </q-toolbar>
</template>

<script>
import { AppFullscreen, Platform } from 'quasar';

export default {
  // name: 'ComponentName',
  props: {
    leftDrawerOpen: Boolean,
    userLogged: Boolean
  },

  data () {
    return {
      fullScreen: false,
      page: {
        title: 'Title',
        subTitle: 'Sub Title'
      }
    }
  },

  mounted () {
    //this.$store.dispatch('auth/actPageSet', this.page.title, this.page.subTitle);
  },
  
  computed: {
    checkIfUserLogged() { 
      return this.$store.getters['auth/getUserLogged'];    
    },

    //pageTitleSet() {
    //  this.$store.dispatch('auth/actPageSet', [this.page.title, this.page.subTitle]);
    //},

    pageTitle() {
      return this.$store.getters['auth/getPageTitle']; 
    },

    pageSubTitle() {
      return this.$store.getters['auth/getPageSubTitle']; 
    }
  },

  methods: {
    toggleFullScreen () {
      this.fullScreen = !this.fullScreen;
      //console.log(this.fullScreen);
      this.fullScreen ? AppFullscreen.toggle() : AppFullscreen.exit();
    }
  }, 
}
</script>

<style>
</style>
