import axios from 'axios'

export function saveToken ({ commit }, payload) {
  commit('SET_TOKEN', payload)
}

export async function fetchUser ({ commit }) {
  try {
    const { data } = await axios.get('me')
    commit('SET_USER', data)
  } catch (e) {
    commit('FETCH_USER_FAILURE')
  }
}

export function setUser ({ commit }, payload) {
  commit('SET_USER', payload)
}

export async function logout ({ commit }) {
  await axios.post('logout')
  commit('LOGOUT')
}

export async function destroy ({ commit }) {
  commit('LOGOUT')
}
