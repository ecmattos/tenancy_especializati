<template>
  <q-page padding>
    <!-- content -->
    <q-tabs>
      <!-- Tabs - notice slot="title" -->
      <q-tab default two-lines label="Auto" slot="title" name="tabCar" icon="directions_car" @click="tabCarSelected"/>
      <q-tab two-lines label="Moto" slot="title" name="tabMotorcycle" icon="motorcycle" @click="tabMotorcycleSelected"/>
      <q-tab two-lines label="Casa" slot="title" name="tabResidence" icon="home" @click="tabResidenceSelected"/>
    </q-tabs>
    <br>
    <div v-if="tabSelected === 'tabCar'">
      <q-card v-for="(plan, index) in allPlansByType" :key="index" inline style="width: auto">
        <q-card-media overlay-position="top">
          <img src="~assets/img/p-assistencia-carro-anual.jpg" class="responsive">
          <!-- Notice the slot="overlay" -->
          <q-card-title slot="overlay">
            {{ plan.plan_type_description }} {{ plan.plan_sub_type_description }}
            <span slot="subtitle">{{ plan.code }}</span>
          </q-card-title>
        </q-card-media>

        <q-card-main>
          <p class="text-faded">{{ plan.details }}</p>
          <h3><p class="text-center">R$ {{ plan.price }}</p></h3>
          <p class="text-faded text-center">ou até 6 x de R$ 36,65.</p>
        </q-card-main>

        <q-card-separator />

        <q-card-actions>
          <q-btn outline color="primary" label="Saiba mais"/>
          <q-btn color="primary" label="Contrate Já" @click="itemAdd"/>
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
  export default {
    data() {
      return {
        tabSelected: 'tabCar',
        planTypeId: 1,
        planSubTypeId: 1
      }
    },

    mounted(){
      this.$store.dispatch('auth/actPageSet', ['PLANOS', 'Assistência Veicular']);
      this.$store.dispatch('plans/actPlans');
    },

    methods: {
      tabCarSelected(){
        this.tabSelected = 'tabCar',
        this.planTypeId = 1,
        this.planSubTypeId = 1
      },
      tabMotorcycleSelected(){
        this.tabSelected = 'tabMotorcycle',
        this.planTypeId = 1,
        this.planSubTypeId = 2
      },
      tabResidenceSelected(){
        this.tabSelected = 'tabResidence',
        this.planTypeId = 1,
        this.planSubTypeId = 3
      },

      itemAdd(){
        this.$store.dispatch('orders/itemAdd')
      }
    },

    computed: {
      allPlansByType() {
        return this.$store.getters['plans/getPlansByType'];   
      }
    }
  }
</script>

<style>
</style>