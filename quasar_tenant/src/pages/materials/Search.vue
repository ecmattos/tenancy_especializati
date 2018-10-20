<template>
  <q-page padding>  
    
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn round color="primary" to="/materials/create" icon="add" />
    </q-page-sticky>

    <q-tabs>
      <!-- Tabs - notice slot="title" -->
      <q-tab default two-lines label="Descrição" slot="title" name="tabSrcDescription" icon="fa fa-edit" @click="tabSrcDescriptionSelected"/>
      <q-tab two-lines label="Código" slot="title" name="tabSrcCode" icon="fa fa-barcode" @click="tabSrcCodeSelected"/>
      <q-tab disable two-lines label="Avançada" slot="title" name="tabSrcAvanced" icon="fa fa-cogs" @click="tabSrcAvancedSelected"/>
    </q-tabs>

    <q-card
      color="blue-grey-11"
      inline style="width: 100%"
      text-color="dark"
      >

      <q-card-title>
      </q-card-title>

      <q-card-main>
        <q-field
          v-if="selectedTab === 'tabSrcDescription'"
          icon-color="dark"
          color-label="primary"
          helper="(Tipo, marca, modelo, serial, código)"
          :error="errors.has('description_terms')"
          :error-label="errors.first('description_terms')"
        >
          <q-chips-input
            autofocus
            float-label="Informe algumas características"
            type="text"
            v-model="search.description_terms"
          />
        </q-field>

        <q-field
          v-else-if="selectedTab === 'tabSrcCode'"
          icon-color="dark"
          color-label="primary"
          helper="(Código de identificação)"
          :error="errors.has('description_terms')"
          :error-label="errors.first('description_terms')"
        >
          <q-chips-input
            autofocus
            float-label="Informe o Código"
            type="number"
            v-model="search.description_terms"
          />
        </q-field>
      </q-card-main>

      <q-card-separator/>

      <q-card-actions>
        <q-btn
          :loading="loading"
          :disable="loading"
          :label="btnSubmitLabel"
          glossy
          color="primary"
          align="center"
          size="md"
          @click="onSubmit"
        />
      </q-card-actions>
    </q-card>

    <hr>

    <q-table
      :data="allMaterials"
      :columns="columns"
      color="amber"
      row-key="name"
      no-data-label="Sem REGISTROS"
      rows-per-page-label="Registros por página"
      :pagination-label="paginationLabel"
    >
      <q-tr slot="body" slot-scope="props" :props="props" @click.native="openProduct(props.row)" class="cursor-pointer">
        <q-td v-for="col in props.cols" :key="col.name" :props="props">
          {{ col.value }}
        </q-td>
      </q-tr>
    </q-table>

  </q-page>
</template>

<script>
  import axios from 'axios';
  import { CONFIG } from '../../config';
  
  export default {
    data() {
      return {
        loading: false,
        btnSubmitLabel: "Pesquisar",
        search: {
          description_terms: []
        },
        columns: [
          {
            name: 'code',
            field: 'code',
            align: 'left',
            label: 'CÓDIGO',
            sortable: true
          },
          {
            name: 'description',
            field: 'description',
            align: 'left',
            label: 'DESCRIÇÃO',
            sortable: true
          },
          {
            name: 'material_unit_code',
            field: 'material_unit_code',
            align: 'left',
            label: 'UNID',
            sortable: false
          }
        ],
        selectedTab: 'tabSrcDescription'
      }
    },
    mounted(){
      this.$store.dispatch('auth/actPageSet', ['MATERIAIS', 'Pesquisa']);
    },
    methods: {
      onSubmit () {
        
        this.onSubmitting();

        //console.log('PARAMS', this.search.description_terms)
        if(this.selectedTab == 'tabSrcDescription')
        {
          return axios.post(CONFIG.api_url + '/materials/searchDescription', this.search)
            .then((response) => {
              console.log('srch_materials: ',response.data.materials);
              this.materials = response.data.materials;
              console.log('materials: ', this.materials);
              this.$store.dispatch('materials/actMaterialsSearchDescription', this.materials || []);

              this.onSubmitted();
            })
            .catch(errors => {
              console.log('errors: ', errors.response);
              if (errors.response.status === 400) {
                this.$setErrorsFromResponse(errors.response.data);

                this.$q.notify({
                  message: 'Ops... encontramos alguns problemas !',
                  icon: 'warning',
                  position: 'top-right'
                });

                this.onSubmitted();
              }
            });
        }

        if(this.selectedTab == 'tabSrcCode')
        {
          axios.post(CONFIG.api_url + '/materials/searchCode', this.search)
            .then((response) => {
              this.materials = response.data.materials;
              this.$store.dispatch('materials/actMaterialsSearchCode', this.materials || []);
            })
            .catch(errors => {
            //console.log(errors.status)
            if (errors.response.status === 400) {
              this.$setErrorsFromResponse(errors.response.data);

              this.$q.notify({
                message: 'Ops... encontramos alguns problemas !',
                icon: 'warning',
                position: 'top-right'
              });
            }
          });
        }        
      },

      openProduct(data){
        //console.log(data)
        this.$router.push('/materials/' + data.id);
      },

      paginationLabel(start, end, total){
        return start + ' até ' + end + ' de ' + total;
      },

      tabSrcDescriptionSelected(){
        this.selectedTab = 'tabSrcDescription';
      },

      tabSrcCodeSelected(){
        this.selectedTab = 'tabSrcCode';
      },

      tabSrcAvancedSelected(){
        this.selectedTab = 'tabSrcAvanced';
      },

      onSubmitting() {
        this.loading = true;
        this.btnSubmitLabel = "Pesquisando...";
        this.$q.loadingBar.start();
      },

      onSubmitted() {
        this.loading = false;
        this.btnSubmitLabel = "Pesquisar";
        this.$q.loadingBar.stop();
      }
    },
    computed: {
      allMaterials() {
        return this.$store.getters['materials/getMaterials'];   
      }
    }
  }
</script>

<style>
</style>
