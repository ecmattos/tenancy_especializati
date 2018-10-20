<template>
  <q-layout>
    <div class="fixed fixed-center bg-grey-2 text-white">
      <q-card round-borders class="flex-center text-center" style="width: 350px; padding:10px">
        <!-- Notice the slot="overlay" -->
        <q-card-title>
          <p class="text-primary">
            Informe seus Dados
            <br>
            ou
            <br>
            da sua Empresa
          </p>
          <q-card-media>
            
          </q-card-media>
        </q-card-title>

        <q-card-main>
          <form>
            <div class="text-left q-pa-sm">
              <q-field 
                icon="assignment"
                :error-label="errors.first('cpfcnpj')"
                :error="errors.has('cpfcnpj')"
              >
                <q-input
                  id="cpfcnpj"
                  float-label="CPF ou CNPJ"
                  type="text"
                  v-model.trim="client.cpfcnpj"
                />
              </q-field>
                
              <br>
              
              <q-field 
                icon="face"
                :error-label="errors.first('name')"
                :error="errors.has('name')"
              >
                <q-input
                  id="name"
                  float-label="Nome ou Razão Social"
                  type="text"
                  v-model.trim="client.name"
                />
              </q-field>
                
              <br>
              
              <q-field
                icon="mail"
                :error="errors.has('email')"
                :error-label="errors.first('email')"
              >
                <q-input
                  id="email"
                  float-label="E-mail"
                  type="text"
                  v-model.trim="client.email"
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
          </form>
        </q-card-main>
      </q-card>
    </div>

    <q-layout-footer>
      <q-tabs align="center">
        <!-- Tabs - notice slot="title" -->
        <q-tab two-lines label="Login" slot="title" name="tabLogin" icon="how_to_reg" @click="tabLoginSelected"/>
        <q-tab two-lines label="Código Ativação" slot="title" name="tabVerify" icon="person_add" @click="tabVerifySelected"/>
        <q-tab two-lines label="Senha" slot="title" name="tabRecovery" icon="contact_mail" @click="tabRecoverySelected"/>
      </q-tabs>
    </q-layout-footer>    
  </q-layout>

</template>

<script>
  import axios from 'axios'
  import { CONFIG } from '../../config'

  export default {
    data () {
      return {
        client: {
          cpfcnpj: '',
          name: '',
          email: ''
        },
        submiting: false,
        btnSubmitLabel: "Enviar"
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['REGISTRO', 'Crie uma nova conta']);
    },

    computed: {
    },

    methods: {
      tabLoginSelected() {
        this.tabSelected = 'tabLogin';
        this.$router.push('/login');
      },

      tabVerifySelected() {
        this.tabSelected = 'tabVerify';
        this.$router.push('/verify');
      },
      
      tabRecoverySelected() {
        // alert('Motor')
        this.tabSelected = 'tabRecovery';
        this.$router.push('/recovery');
      },

      onSubmit () {
        this.submiting = true;
        this.btnSubmitLabel = "Verifcando...";

        this.$q.loadingBar.start()
       
        axios.post(CONFIG.api_url + '/clients', this.client)
          .then(response => {
            this.$router.push('/clients/userAdminRegister');

            this.submiting = false;
            this.btnSubmitLabel = "Verificado";
          
            this.$q.notify({
              message: 'Obrigado pelo seu cadastro ! Verifique o seu e-mail para completar o cadastro.',
              icon: 'thumb_up_alt',
              position: 'top-right',
              type: 'positive'
            });

            this.$q.loadingBar.stop();

          }).catch(errors => {
            if (errors.response.status == 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.submiting = false;
              this.btnSubmitLabel = "Enviar";

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
              this.$q.loadingBar.stop();
            }
          });
      }
    }
  }
</script>