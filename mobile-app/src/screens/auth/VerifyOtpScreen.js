import React, { useState, useEffect, useRef } from 'react'
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  ToastAndroid,
} from 'react-native'
import { useIsFocused } from '@react-navigation/native'
import OtpInputs from 'react-native-otp-inputs'
import { get as _get } from 'lodash'

import { MainButton, MainHeader, MainLogo, SwithLang } from '../../components'
import Colors from '../../constants/colors'

import { setLoading } from '../../actions'
import { connect } from 'react-redux'

const VerifyOtpScreen = ({ setLoading, navigation, route }) => {
  const { phoneNumber } = route.params
  const [otpCode, setOtpCode] = useState('')
  const otpRef = useRef()
  const [reSendOtpDelay, setReSendOtpDelay] = useState(300)
  const atHere = useIsFocused()

  useEffect(() => {
    if (atHere) {
      setTimeout(() => {
        if (reSendOtpDelay) {
          setReSendOtpDelay(reSendOtpDelay - 1)
        }
      }, 1000)
    }
  }, [reSendOtpDelay])

  const verifyOtp = () => {
    const data = {
      phone: phoneNumber,
      otp: otpCode,
    }
    setLoading(true)
    axios
      .post('user/verify-otp', data)
      .then(() => {navigation.push('Register', data)})
      .catch(({response}) =>
        ToastAndroid.showWithGravity(
          _get(response, 'data.result.errors.otp'),
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      )
      .finally(() => setLoading(false))
  }

  useEffect(() => {
    if (atHere) {
      setTimeout(() => {
        otpRef.current.focus()
      }, 100)
    }
  }, [])

  const reSendOtp = () => {
    if (reSendOtpDelay) {
      return
    }
    setLoading(true)
    setTimeout(() => {
      setReSendOtpDelay(300)
      setLoading(false)
    }, 1000)
  }

  return (
    <View style={styles.container}>
      <MainHeader
        goBack={() => navigation.push('SendOtp')}
        title={$t('screens.verifyOtp.title')}
        rightComponent={<SwithLang/>}
      />
      <MainLogo isShow={true} containerStyle={styles.logoContainer} />
      <View style={styles.messageEnterPhone}>
        <Text style={styles.textCenter}>
          {$t('screens.verifyOtp.description')}
        </Text>
      </View>
      <View style={styles.groupOtpCode}>
        <OtpInputs
          ref={otpRef}
          handleChange={(code) => setOtpCode(code)}
          inputStyles={styles.inputOtpCode}
          keyboardType="numeric"
          inputContainerStyles={styles.otpField}
          numberOfInputs={6}
        />
      </View>
      <View style={styles.row}>
        <Text>{mmss(reSendOtpDelay)} :</Text>
        <TouchableOpacity onPress={reSendOtp}>
          <Text
            style={{
              color: reSendOtpDelay ? Colors.secondary : Colors.primary,
            }}
          >
            {' '}
            {$t('commons.reSend')}
          </Text>
        </TouchableOpacity>
      </View>
      <View style={styles.buttonVerify}>
        <MainButton
          onPress={verifyOtp}
          text={$t('commons.sendVerifyCode').toUpperCase()}
          enable={otpCode.length == 6}
        />
      </View>
    </View>
  )
}

export default connect(mapState, { setLoading })(VerifyOtpScreen)

const pad = (num) => {
  return ('0' + num).slice(-2)
}

const mmss = (ss) => {
  let mm = Math.floor(ss / 60)
  ss = ss % 60
  mm = mm % 60
  return `${pad(mm)}:${pad(ss)}`
}

const mapState = (state) => ({ state })

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: '5%',
    backgroundColor: Colors.white,
  },

  textCenter: {
    textAlign: 'center',
  },
  logoContainer: {
    marginVertical: 15,
  },
  buttonVerify: {
    width: '100%',
    marginLeft: '5%',
    position: 'absolute',
    bottom: 0,
  },
  groupOtpCode: {
    height: 35,
    marginHorizontal: 50,
  },
  inputOtpCode: {
    textAlign: 'center',
    width: '100%',
    height: 40,
  },
  otpField: {
    width: '13%',
    borderBottomWidth: 1,
    borderBottomColor: Colors.secondary,
  },
  row: {
    marginTop: 20,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
  },
})
