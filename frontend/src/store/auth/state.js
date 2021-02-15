import { LocalStorage } from 'quasar'

export default function () {
  return {
    user: null,
    token: LocalStorage.getItem('token')
  }
}
