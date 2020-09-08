import React from 'react'
import { get as _get } from 'lodash'

import AppNavigator from '../navigations/AppNavigator'
import AuthNavigator from '../navigations/AuthNavigator'
import WakeupScreen from './WakeupScreen'

import { connect } from 'react-redux'

const RootScreen = ({ state }) => {
  let isLogin = _get(state, 'auth.isLogin')
  let wakeup = _get(state, 'app.wakeup')

  return !wakeup ? (
    <WakeupScreen />
  ) : !isLogin ? (
    <AuthNavigator />
  ) : (
        <AppNavigator />
      )
}
const mapState = (state) => ({ state })

export default connect(mapState, null)(RootScreen)
