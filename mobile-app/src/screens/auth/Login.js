import React, { useState } from 'react'
import {
  StyleSheet,
  View,
  Text,
  ToastAndroid,
  TouchableOpacity,
} from 'react-native'
import { get as _get } from 'lodash'
import * as Permissions from 'expo-permissions'
import { Notifications } from 'expo'
import {
  MainGroupInput,
  MainButton,
  MainLogo,
  MainCheckBox,
  SwithLang,
} from '../../components'
import Colors from '../../constants/colors'

import { setLoading, setAuth } from '../../actions'
import { connect } from 'react-redux'

const LoginScreen = ({ setLoading, setAuth, navigation }) => {
  const [username, setUsername] = useState('')
  const [password, setPassword] = useState('')
  const [remember, setRemember] = useState(false)

  const handleLogin = async () => {
    setLoading(true)
    const params = { username, password, remember }
    try {
      const { status: existingStatus } = await Permissions.getAsync(
        Permissions.NOTIFICATIONS
      )
      if (existingStatus === 'granted') {
        let mobile_token = await Notifications.getExpoPushTokenAsync()
        params.mobile_token = mobile_token
      }
    } catch (error) {
      console.log(error)
    }
    axios
      .post('user/login', params)
      .then(({ data }) => {
        const { token, user } = _get(data, 'result.success')
        setAuth({ token, user })
      })
      .catch((e) => {
        ToastAndroid.showWithGravity(
          $t('screens.login.failed'),
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      })
      .finally(() => {
        setLoading(false)
      })
  }

  return (
    <View style={styles.container}>
      <View style={{ paddingTop: 45, alignItems: 'flex-end' }}>
        <SwithLang />
      </View>
      <MainLogo size={120} containerStyle={{ marginBottom: 45 }} />
      <MainGroupInput
        iconName="ios-call"
        rules="required"
        name={'phone'}
        value={username}
        placeholder={$t('commons.phoneNumber')}
        onChangeText={(text) => setUsername(text)}
      />
      <MainGroupInput
        iconName="ios-lock"
        rules={'required'}
        name={'password'}
        value={password}
        securable={true}
        placeholder={$t('commons.password')}
        onChangeText={(text) => setPassword(text)}
      />
      <View style={styles.rememberStyle}>
        <MainCheckBox
          onPress={() => setRemember(!remember)}
          value={remember}
          title={$t('commons.remember')}
        />
        <TouchableOpacity
          style={styles.row}
          onPress={() =>
            ToastAndroid.showWithGravity(
              $t('commons.wip'),
              ToastAndroid.SHORT,
              ToastAndroid.CENTER
            )
          }
        >
          <Text>{$t('commons.fogotPassword')}?</Text>
          <Text style={styles.textLink}>{' ' + $t('commons.recoverNow')}</Text>
        </TouchableOpacity>
      </View>
      <MainButton
        onPress={handleLogin}
        text={$t('commons.login').toUpperCase()}
        enable={password && username}
      />
      <View style={styles.row}>
        <Text>{$t('commons.notHaveAccount')}?</Text>
        <Text
          style={styles.textLink}
          onPress={() => navigation.push('SendOtp')}
        >
          {' ' + $t('commons.registerNow')}
        </Text>
      </View>
    </View>
  )
}
const mapState = (state) => ({ state })

export default connect(mapState, { setLoading, setAuth })(LoginScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: '5%',
    backgroundColor: Colors.white,
  },
  textLink: {
    color: Colors.primary,
  },
  errorGroup: {
    height: 30,
    marginTop: 20,
    justifyContent: 'center',
    alignItems: 'center',
  },
  errorText: {
    color: Colors.danger,
    fontStyle: 'italic',
    fontSize: 13,
  },
  rememberStyle: {
    marginTop: 0,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  row: {
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
  },
})
