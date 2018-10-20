import { SessionStorage } from 'quasar';

export function actUserLogged (context) {
  let token = SessionStorage.get.item('token');
  console.log('actToken: ', token);
  let user = SessionStorage.get.item('user');
  console.log('actUser: ', user);
  
  context.commit('MUT_USER_LOGGED', { token, user });
}

export function actUserLogout (context) {
  SessionStorage.clear();
  context.commit('MUT_USER_LOGOUT');   
}

export function actPageSet (context, [ pageTitle, pageSubTitle ]) {
  console.log('actTitle: ', pageTitle);
  console.log('actSubTitle: ', pageSubTitle);

  context.commit('MUT_PAGE_SET', { pageTitle, pageSubTitle });
}