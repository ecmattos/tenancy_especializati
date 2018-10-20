import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import materials from './materials';
import plans from './plans';

Vue.use(Vuex);

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      auth,
      materials,
      plans
    }
  });

  return Store;
}
