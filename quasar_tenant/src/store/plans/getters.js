export function getPlansByType (state) {
    return state.plans;
    //return state.filter(plans => plans.plan_type_id == 1)
}

//export function getPlansByType(state, plan_type_id) {
//    return state.filter(plans => plans.plan_type_id == plan_type_id)
//}