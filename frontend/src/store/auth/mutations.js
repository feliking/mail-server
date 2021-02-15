import { LocalStorage } from 'quasar'

export const SET_USER = (state, { user }) => {
  state.user = user
}

export const LOGOUT = (state) => {
  state.user = null
  state.token = null
  LocalStorage.remove('token')
}

export const FETCH_USER_FAILURE = (state) => {
  state.user = null
  LocalStorage.remove('token')
}

export const SET_TOKEN = (state, { token }) => {
  state.token = token
  LocalStorage.set('token', token)
}
