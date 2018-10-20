export function MUT_USER_LOGGED (state, { token, user }) {
  state.token = token;
  //console.log('mutToken: ', token);
  state.user = user;
  //console.log('mutUser: ', user);
}

export function MUT_USER_LOGOUT (state) {
  state.token = '';
  state.user = [];
}

export function MUT_PAGE_SET (state, { pageTitle, pageSubTitle }) {
  console.log('pageSubTitle: ', pageSubTitle);
  state.page.title = pageTitle;
  state.page.subTitle = pageSubTitle;
} 
    