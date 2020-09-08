import { combineReducers } from 'redux'
import app from './app'
import auth from './auth'

const reducers = combineReducers({
  app,
  auth
})

export default reducers
