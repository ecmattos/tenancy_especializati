import VeeValidate from 'vee-validate'

// leave the export, even if you don't use it
export default ({ Vue }) => {

  Vue.use(VeeValidate)

  Vue.prototype.$setErrorsFromResponse = function(errorResponse) {
    console.log('errorResponse: ', errorResponse)
    // only allow this function to be run if the validator exists
    if(!this.hasOwnProperty('$validator')) {
      return
    }
    
    // clear errors
    this.$validator.errors.clear()

    // check if errors exist
    if(!errorResponse.hasOwnProperty('errors')) {
      return
    }

    let errorFields = Object.keys(errorResponse.errors)

    // insert laravel errors
    errorFields.map(field => {
      let errorString = errorResponse.errors[field].join(', ')
      this.$validator.errors.add({ field: field, msg: errorString })       
    })
  }
}