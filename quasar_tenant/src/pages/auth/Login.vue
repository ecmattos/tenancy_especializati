<template>
  <q-layout id="login">
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Informe suas Credenciais
          </p>
          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field
                icon="mail"
                :error="errors.has('email')"
                :error-label="errors.first('email')">
                  <q-input
                    id="email"
                    float-label="E-mail"
                    type="text"
                    v-model.trim="credentials.email">
                  </q-input>
              </q-field>

              <br>

              <q-field
                icon="lock"
                :error-label="errors.first('password')"
                :error="errors.has('password')">
                <q-input
                  id="password"
                  float-label="Senha"
                  type="password"
                  v-model.trim="credentials.password">
                </q-input>
              </q-field>

              <br>

              <q-btn
                :loading="submiting"
                :disable="submiting"
                :label="btnSubmitLabel"
                class="full-width"
                color="primary"
                @click.prevent="onSubmit ()">
              </q-btn>
              
              <br>
            </div>
          </form>
        </q-card-main>
      </q-card>
    </div>

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Conta" slot="title" name="tabRegister" icon="person_add" @click="tabRegisterSelected"/>
        <q-tab two-lines label="Senha" slot="title" name="tabRecover" icon="contact_mail" @click="tabRecoverySelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  import { SessionStorage } from 'quasar';

  export default
  {
    data () {
      return {
        credentials: {
          email: 'admin@gmail.com',
          password: 'secret'
        },
        submiting: false,
        btnSubmitLabel: "Entrar",
        loginSuccess: false
      }
    },

    mounted () {
      this.$store.dispatch('auth/actUserLogout');
      this.$store.dispatch('auth/actPageSet', ['LOGIN', 'Identificação']);
    },

    methods: {
      tabRegisterSelected() {
        this.tabSelected = 'tabRegister';
        //this.$store.dispatch('auth/actPageSet', ['REGISTRO', 'Crie uma nova conta']);
        //this.$router.push('/register');
        this.$router.push('/clients/new');
      },
      
      tabRecoverySelected() {
        this.tabSelected = 'tabRecovery';
        //this.$store.dispatch('auth/actPageSet', ['RECUPERAÇÂO DA SENHA', 'Recupere a sua senha de acesso']);
        this.$router.push('/recovery');
      },

      onSubmit () {
        this.submiting = true;
        this.btnSubmitLabel = "Verifcando...";
        this.$q.loadingBar.start();
       
        axios.post(CONFIG.api_url + '/login', this.credentials)
          .then(response => {
            let token = response.data.access_token.token;
            SessionStorage.set('token', token);
            
            let user = response.data.user;
            SessionStorage.set('user', user);

            this.$store.dispatch('auth/actUserLogged', user);
            
            this.$store.dispatch('auth/actPageSet', ['Painel de Controle', 'Visão Geral']);
            this.$router.push({ path: '/dashboard' });
            this.$q.loadingBar.stop();
            
          }).catch(errors => {
            console.log(errors);
            
            if (errors.response.status === 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Entrar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
            }
            
          });

        this.$q.loadingBar.stop();        
      }
    }
  }
</script>

<style scoped>
</style>