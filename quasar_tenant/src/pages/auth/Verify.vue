<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Ativação de conta
          </p>
          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <div class="text-left q-pa-sm">
            <q-field
              icon="lock"
              :error="errors.has('codeVerification')"
              :error-label="errors.first('codeVerification')"
              >
                <q-input
                  id="codeVerification"
                  float-label="Código verificação"
                  type="text"
                  v-model.trim="credentials.codeVerification"
                  autofocus
                />
            </q-field>

            <br>

            <q-btn
              :loading="submiting"
              :disable="submiting"
              :label="btnSubmitLabel"
              class="full-width"
              color="primary"
              @click="onSubmit ()">
            </q-btn>
            
            <br>
          </div>
        </q-card-main>
      </q-card>
    </div>

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Login" slot="title" name="tabLogin" icon="how_to_reg" @click="tabLoginSelected"/>
        <q-tab two-lines label="Conta" slot="title" name="tabRegister" icon="person_add" @click="tabRegisterSelected"/>
        <q-tab two-lines label="Reenviar Código" slot="title" name="tabRecovery" icon="mail" @click="tabRecoverySelected"/>
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
          codeVerification: ''
        },
        submiting: false,
        btnSubmitLabel: "Confirmar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['CONFIRMAÇÂO DA CONTA', 'Ative a sua conta']);  
    },

    methods : {
      tabLoginSelected() {
        this.tabSelected = 'tabLogin';
        this.$router.push('/login');
      },

      tabRegisterSelected() {
        this.tabSelected = 'tabRegister';
        this.$router.push('/register');
      },
      
      tabRecoverySelected() {
        // alert('Motor')
        this.tabSelected = 'tabRecovery';
        this.$router.push('/recovery');
      },
      onSubmit() {
        this.$q.loadingBar.start();

        this.submiting = true;
        this.btnSubmitLabel = "Verifcando...";

        axios.post(CONFIG.api_url + '/verify', this.credentials)
          .then(response => {
            
            this.submiting = false;
            this.btnSubmitLabel = "Verificado";
          
            this.$q.notify({
              message: 'Obrigado ! Sua conta foi ativada.',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });

            this.$router.push({ path: '/login' });
            this.$q.loadingBar.stop();

          }).catch(errors => {
            if (errors.response.status == 401) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Confirmar";

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

<style>
</style>


