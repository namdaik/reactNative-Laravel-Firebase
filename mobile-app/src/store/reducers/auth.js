import { AsyncStorage } from 'react-native'
import { get as _get } from 'lodash'

const initialState = {
  isLogin: false,
  token: null,
  user: null,
}

const auth = (state = initialState, action) => {
  let { user, token } = action
  let isLogin = !user || !token ? false : true
  switch (action.type) {
    case 'SET_AUTH':
      if (token) {
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
        AsyncStorage.setItem('@Auth:token', token)
      } else {
        AsyncStorage.removeItem('@Auth:token')
      }
      if (user && typeof user !== 'string') {
        AsyncStorage.setItem('@Auth:user', JSON.stringify(user))
      } else {
        AsyncStorage.removeItem('@Auth:user')
      }
      return { ...state, user, token, isLogin }

    case 'SET_AUTH':
      return { ...state, user }
    default:
      return state
  }
}

export default auth
