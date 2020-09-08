import React, { useEffect } from 'react'
import { View, ActivityIndicator, AsyncStorage } from 'react-native'
import { get as _get } from 'lodash'

import Colors from '../constants/colors'

import { setWakeup, setAuth } from '../actions'
import { connect } from 'react-redux'

const WakeupScreen = ({ setWakeup, setAuth }) => {
  const checkLogin = async () => {
    const token = await AsyncStorage.getItem('@Auth:token')
    const config = {
      headers: { Authorization: `Bearer ${token}` },
    }
    if (token) {
      await axios
        .get('auth/show/user', config)
        .then(({ data }) => {
          let user = _get(data, 'result.success.user')
          setAuth({ token, user })
        })
        .catch(() => setAuth(null))
    }
    setWakeup(true)
  }

  useEffect(() => {
    checkLogin()
  }, [])

  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <ActivityIndicator size="large" color={Colors.primary} />
    </View>
  )
}

export default connect(null, { setWakeup, setAuth })(WakeupScreen)
