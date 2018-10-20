import { SessionStorage } from 'quasar';

export default {
  //
  token: SessionStorage.get.item('token'),
  user: SessionStorage.get.item('user'),
  page : {
    title: 'LOGIN',
    subTitle: 'Identificação'
  }
}
