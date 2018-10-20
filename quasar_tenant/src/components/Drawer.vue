<template>
  <q-layout-drawer
      v-model="localLeftDrawerOpen"
      :content-class="$q.theme === 'mat' ? 'bg-grey-2' : null"
      :overlay=true
    >
      <div>
        <q-list highlight>
          <q-list-header>
            SiGeS - {{ userLoggedInfo.client.name }} 
          </q-list-header>
          <q-item>
            <q-item-side>
              <q-item-tile avatar>
                <img src="~assets/img/user_default.png" />
              </q-item-tile>
            </q-item-side>
            <q-item-main>
              <q-item-tile label>{{ userLoggedInfo.name }}</q-item-tile>
              <q-item-tile sublabel>{{ userLoggedInfo.role }}</q-item-tile>
              <q-item-tile sublabel>{{ userLoggedInfo.email }}</q-item-tile>
            </q-item-main>
            <q-item-side right>
              <q-btn
                round
                size="sm"
                color="negative"
                @click="logout"
                icon="exit_to_app"
              />
            </q-item-side>
          </q-item>
        </q-list>
      </div>
     
      <q-list
        no-border
        link
        inset-delimiter
      >
      
        <q-list-header>Menu</q-list-header>
        <q-item to="/materials">
          <q-item-side icon="school" />
          <q-item-main label="Materiais" sublabel="Almoxarifados" />
        </q-item>
        <q-item to="/plans">
          <q-item-side icon="code" />
          <q-item-main label="Planos" sublabel="Assistências Veiculares" />
        </q-item>
        <q-item @click.native="openURL('https://discord.gg/5TDhbDg')">
          <q-item-side icon="chat" />
          <q-item-main label="Discord Chat Channel" sublabel="https://discord.gg/5TDhbDg" />
        </q-item>
        <q-item @click.native="openURL('http://forum.quasar-framework.org')">
          <q-item-side icon="record_voice_over" />
          <q-item-main label="Forum" sublabel="forum.quasar-framework.org" />
        </q-item>
        <q-item @click.native="openURL('https://twitter.com/quasarframework')">
          <q-item-side icon="rss feed" />
          <q-item-main label="Twitter" sublabel="@quasarframework" />
        </q-item>
      </q-list>
    </q-layout-drawer>
</template>

<script>
import { openURL } from 'quasar';
export default {
  props: {
    /* this prop gets passed down from our parent - it should NOT be manipulated directly! */
    leftDrawerOpen: {
      required: true,
      type: Boolean
    }, 
    userLoggedInfo: {
      required: false,
      type: Object
    }
  },

  data () {
    return {
      /* A local data copy of our prop - which CAN be manipulated here */
      localLeftDrawerOpen: false
    }
  },
    
  methods: {
    openURL,
    
    logout() {
      this.localLeftDrawerOpen = false;
      
      this.$store.dispatch('auth/actPageSet', ['LOGIN', 'Identificação']);
      this.$store.dispatch('auth/actUserLogout');
      this.$router.push('/login');
    }
  },
  
  watch: {
    /* If our prop ever gets changed outside of this component then we need to update our local data version of the prop */
    leftDrawerOpen (newVal) {
      this.localLeftDrawerOpen = newVal;
    }
  },

  mounted () {
    /* As soon as the component is mounted convert our passed prop into data*/
    /* This line may or may not be necessary - The watch function probably covers it already, but I haven't tested without it yet */
    this.localLeftDrawerOpen = this.leftDrawerOpen;
  }
}
</script>

<style>
</style>
