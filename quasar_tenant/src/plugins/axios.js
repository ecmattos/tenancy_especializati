import axios from 'axios';
import { CONFIG } from './../config';
import { SessionStorage } from 'quasar';

export default ({ Vue }) => {
  Vue.prototype.$axios = axios;

  axios.interceptors.request.use((config) => {
    try {
      let token = SessionStorage.get.item('token');
      //console.log('token: ', token);
      
      if (token) {
        config.headers.Authorization = `Bearer ` + token;
      }

      return config;

    } catch(error) {
      //console.log('errors1: ', error.status);
    }
  })

  axios.interceptors.response.use(function (response) {
    return response;
  }, function (error) {
   
    let token = SessionStorage.get.item('token');
    
    const originalRequest = error.config;

    //if (error.response.status === 401 && !originalRequest._retry) {
    //  /*
    //  Desabilita o refresh nas pages login e register
    //  */
    //  if ((originalRequest.url !== CONFIG.api_url + '/login') & (originalRequest.url !== CONFIG.api_url + '/register')) {
    //    originalRequest._retry = true;
    //    /*
    //    Se existe token vencido: refresh
    //    */
    //    if (token !== null) {
    //      return axios.post(CONFIG.api_url + '/refresh')
    //        .then(({ data }) => {
    //          localStorage.setItem('token', data.access_token.token);
    //          axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token.token;
    //          originalRequest.headers['Authorization'] = 'Bearer ' + data.access_token.token;
    //
    //          return axios(originalRequest);
    //        });
    //    } else {
    //      /*
    //      Se não existe token: login
    //      */
    //      //router.push({ path: '/login' });
    //    }
    //  } 
    //  return Promise.reject(error);
    //}
       
   
    if (error.response.status === 401 && !originalRequest._retry) {
   
      originalRequest._retry = true;
   
      //const refreshToken = window.localStorage.getItem('refreshToken');
      return axios.post(CONFIG.api_url + '/refresh')
        .then(({data}) => {
          console.log('token: ', data.access_token.token);
          SessionStorage.set('token', data.access_token.token);
          //window.localStorage.setItem('refreshToken', data.refreshToken);
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token.token;
          originalRequest.headers['Authorization'] = 'Bearer ' + data.access_token.token;

          return axios(originalRequest);
        })
    }   
    return Promise.reject(error);
   
  
  });
}



