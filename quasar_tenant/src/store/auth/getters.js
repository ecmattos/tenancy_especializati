export function getUserLogged (state) {
    return state.token ? true : false;
}

export function getUserLoggedInfo (state) {
    return state.user;
}

export function getPageTitle (state) {
    return state.page.title;
}

export function getPageSubTitle (state) {
    return state.page.subTitle;
}