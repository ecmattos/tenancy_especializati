export function MUT_MATERIALS_LIST (state, materials) {
  state.materials = materials
}

export function MUT_MATERIAL_SAVE (state, material) {
  state.materials.push(material)
}

export function MUT_MATERIAL_DESTROY (state, material) {
  state.materials.splice(material)
}