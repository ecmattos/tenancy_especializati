<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header>
      <toolbar-component :left-drawer-open=leftDrawerOpen :user-logged="checkIfUserLogged"/>
    </q-layout-header>
  
    <drawer-component :left-drawer-open=leftDrawerOpen :user-logged-info="checkUserLoggedInfo"/>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import ToolbarComponent from './../components/Toolbar';
import DrawerComponent from './../components/Drawer';

export default {
  name: 'MyLayout',
  data () {
    return {
      leftDrawerOpen: false,
      fullScreen: false
    }
  },
  
  mounted () {
    var self = this;
    //List for $emits from any child components
    this.$root.$on('toggle_left_drawer', function() {
      /* our parent's data is updated, which in turn updates the sidebars props, which in turn updates the sidebars local data - NO WARNINGS :) */
      self.leftDrawerOpen = !self.leftDrawerOpen;
    });
  },

  components: {
    ToolbarComponent,
    DrawerComponent
  },

  computed: {
    checkIfUserLogged() { 
      return this.$store.getters['auth/getUserLogged'];    
    },
    
    checkUserLoggedInfo() { 
      return this.$store.getters['auth/getUserLoggedInfo'];
    }
  }
}
</script>

<style>
</style>