<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Esqueceu a Senha ?
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
          </form>
        </q-card-main>
      </q-card>
    </div>

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Login" slot="title" name="tabLogin" icon="how_to_reg" @click="tabLoginSelected"/>
        <q-tab two-lines label="Conta" slot="title" name="tabRegister" icon="person_add" @click="tabRegisterSelected"/>
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
          email: ''
        },
        submiting: false,
        btnSubmitLabel: "Enviar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['RECUPERAÇÂO DA SENHA', 'Recupere a sua senha de acesso']);  
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
      
      onSubmit() {
        this.$q.loadingBar.start();

        this.submiting = true;
        this.btnSubmitLabel = "Verifcando...";

        axios.post(CONFIG.api_url + '/recovery', this.credentials)
          .then(response => {
            
            this.submiting = false;
            this.btnSubmitLabel = "Verificado";
          
            this.$q.notify({
              message: 'Solicitação recebida. Favor verificar seu e-mail.',
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


