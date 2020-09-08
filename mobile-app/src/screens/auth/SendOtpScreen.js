import React, { useState, useEffect } from 'react'
import {
  StyleSheet,
  Text,
  View,
  Image,
  TextInput,
  TouchableOpacity,
  ToastAndroid,
} from 'react-native'
import { get as _get } from 'lodash'

import { MainButton, MainHeader, MainLogo, SwithLang } from '../../components'
import Colors from '../../constants/colors'

import { setLoading } from '../../actions'
import { connect } from 'react-redux'

const SendOtpScreen = ({ setLoading, navigation }) => {
  const [phoneNumber, setPhoneNumber] = useState('')
  const [errorPhone, setErrorPhone] = useState('')
  useEffect(() => {
    return async () => {
      await setPhoneNumber('')
      await setErrorPhone('')
    }
  }, [])

  const changePhoneNumber = (text) => {
    setPhoneNumber(text)
    setErrorPhone('')
    if (text == '') {
      let attribute = $t('commons.phoneNumber')
      setErrorPhone($t('validation.required', { attribute }))
    }
  }

  const sendOtp = () => {
    setLoading(true)
    axios
      .post('user/send-otp', { phone: phoneNumber })
      .then(() => navigation.push('VerifyOtp', { phoneNumber }))
      .catch(({ response }) => {
        ToastAndroid.showWithGravity(
          _get(response, 'data.result.errors.phone.0')|| 'Số điện thoại không tồn tại',
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      })
      .finally(() => setLoading(false))
  }

  return (
    <View style={styles.container}>
      <MainHeader
        goBack={() => navigation.push('Login')}
        title={$t('screens.sendOtp.title')}
        rightComponent={
          <SwithLang />
        }
      />
      <MainLogo isShow={true} containerStyle={styles.logoContainer} />
      <View style={styles.messageEnterPhone}>
        <Text style={styles.textCenter}>
          {$t('screens.sendOtp.description')}
        </Text>
      </View>
      <View style={styles.groupPhoneNumber}>
        <View style={styles.labelPhoneNumber}>
          <TouchableOpacity style={styles.labelPhoneNumberChil}>
            <Image
              style={styles.flag}
              source={require('../../assets/images/flags/vn.png')}
            />
            <Text>+84</Text>
          </TouchableOpacity>
        </View>
        <View style={styles.rightPhone}>
          <View>
            <TextInput
              textContentType="telephoneNumber"
              keyboardType="numeric"
              name={$t('phone')}
              style={styles.inputPhoneNumber}
              value={phoneNumber}
              onChangeText={(text) => changePhoneNumber(text)}
              placeholder={$t('commons.enterYourPhone')}
            />
            <Text style={{ color: Colors.red, fontStyle: 'italic' }}>
              {errorPhone}
            </Text>
          </View>
        </View>
      </View>
      <View style={styles.buttonSendOtp}>
        <MainButton
          onPress={sendOtp}
          text={$t('commons.sendVerifyCode').toUpperCase()}
          enable={!errorPhone && phoneNumber}
        />
      </View>
    </View>
  )
}

const mapState = (state) => ({ state })

export default connect(mapState, { setLoading })(SendOtpScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: '5%',
    backgroundColor: Colors.white,
  },
  messageEnterPhone: {
    marginBottom: 20,
  },
  textCenter: {
    textAlign: 'center',
  },
  logoContainer: {
    paddingVertical: 18,
  },
  buttonSendOtp: {
    width: '100%',
    marginLeft: '5%',
    position: 'absolute',
    bottom: 0,
  },
  groupPhoneNumber: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    width: '100%',
    height: 35,
  },
  labelPhoneNumber: {
    borderBottomWidth: 1,
    borderBottomColor: Colors.secondary,
    justifyContent: 'center',
    flex: 0.17,
  },
  labelPhoneNumberChil: {
    alignItems: 'center',
    flexDirection: 'row',
  },
  inputPhoneNumber: {
    borderBottomWidth: 1,
    borderBottomColor: Colors.secondary,
    height: 35,
  },
  rightPhone: {
    flex: 0.78,
  },
  flag: {
    width: 24,
    height: 17,
    marginRight: 5,
  },
})
