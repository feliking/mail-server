import axios from 'axios'
import { Notify } from 'quasar'

export default ({ app, router, store, Vue }) => {
  axios.defaults.baseURL = process.env.API

  axios.interceptors.request.use(config => {
    config.headers['X-Requested-With'] = 'XMLHttpRequest'

    const token = store.getters['auth/token']
    if (token) {
      config.headers.Authorization = 'Bearer ' + token
    }
    return config
  }, error => {
    return Promise.reject(error)
  })

  axios.interceptors.response.use(response => {
    return response
  }, async error => {
    if (store.getters['auth/token']) {
      if (error.response.status === 401 && error.response.data.message === 'Token has expired') {
        const { data } = await axios.post('login/refresh')
        store.dispatch('auth/saveToken', data)
        return axios.request(error.config)
      }
      if (error.response.status === 401 ||
        (error.response.status === 500 && (
          error.response.data.message === 'El token expiró y no puede actualizarse de nuevo' ||
          error.response.data.message === 'El token esta en la lista negra'
        ))
      ) {
        store.dispatch('auth/destroy')
        router.push({ name: 'login' })
      }
    }
    error.response.data.message !== undefined && Notify.create({ color: 'negative', message: error.response.data.message, position: 'bottom-right' })
    error.response.data.error !== undefined && Notify.create({ color: 'negative', message: 'Algo salió mal.', position: 'bottom-right' })
    return Promise.reject(error)
  })
  Vue.prototype.$axios = axios
}
