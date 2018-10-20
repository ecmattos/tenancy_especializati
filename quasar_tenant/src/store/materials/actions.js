export function actMaterialsSearchCode (context, search) {
  context.commit('MUT_MATERIALS_LIST', response.data.material || []);
}

export function actMaterialsSearchDescription (context, materials) {  
  console.log('actMaterials: ', materials);
  context.commit('MUT_MATERIALS_LIST', materials || []);
}

export function materialSave (context, material) {
  console.log('DATA:', material)
  axios.post(CONFIG.api_url + '/materials', material)
    .then((response) => {
      console.log(response)
      context.commit('MATERIAL_SAVE', material)
    })
    .catch((error) => {
      //console.log(error.response.data)
    })
}

export function materialDestroy (context, id) {
  axios.get(CONFIG.api_url + '/materials/' + id + '/destroy')
    .then((response) => {
      //console.log(response.data.data)
      context.commit('MATERIAL_DESTROY', id)
      this.$router.push('/materials')
    })
}

export function materialsErrorsClear (context) {
  context.commit('MATERIALS_ERRORS_CLEAR')
}
