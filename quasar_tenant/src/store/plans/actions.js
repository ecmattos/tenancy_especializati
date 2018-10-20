import axios from 'axios'
import { CONFIG } from '../../config'

export function actPlans (context) {
  //console.log('PARAMS -> ', search)
  axios.get(CONFIG.api_url + '/plans')
    .then((response) => {
      console.log('plans: ', response.data.plans.data)
      context.commit('MUT_PLANS_LIST', response.data.plans.data || [])
    })
    .catch((error) => {
      console.log(error)
    })
}