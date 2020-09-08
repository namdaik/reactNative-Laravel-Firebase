import React, { useState, useEffect } from 'react'
import {
  StyleSheet,
  View,
  KeyboardAvoidingView,
  Image,
  Text,
} from 'react-native'
import { get as _get } from 'lodash'
import { MainButton, MainGroupInput, MainLogo } from '../../../components'
import { connect } from 'react-redux'
import Colors from '../../../constants/colors'
import { setLoading } from '../../../actions'
const UpdateProfileScreen = ({ state, setLoading }) => {
  const curentUser = state.auth.user
  const [fullName, setFullName] = useState(curentUser.name)
  const [address, setAddress] = useState(curentUser.address)
  const [email, setEmail] = useState(curentUser.email)
  const [gender, setGender] = useState(false)
  const [canUpdateProfile, setCanUpdateProfile] = useState(false)
  const checkForm = () => {
    if (!fullName) {
      return false
    }
    return true
  }
  useEffect(() => {
    setCanUpdateProfile(checkForm())
  }, [fullName])
  const updateProfile = async () => {
    setLoading(true)
    let params = {
      name: fullName,
    }
    axios
      .post('user/register', params)
      .then(({ data }) => {})
      .catch(({ response }) => {
        console.log(response.data)
      })
      .finally(() => {
        setLoading(false)
      })
  }

  return (
    <View style={styles.container}>
      <KeyboardAvoidingView behavior="padding">
        <MainLogo/>
        <View style={styles.groupPhone}>
          <Text style={styles.userphone}>{curentUser.phone}</Text>
        </View>
        <MainGroupInput
          iconName="ios-person"
          placeholder={$t('fullName')}
          onChangeText={(text) => setFullName(text)}
          value={fullName}
          rules="required"
        />

        <MainGroupInput
          iconName="ios-mail"
          placeholder={$t('email')}
          onChangeText={(text) => setEmail(text)}
          value={email}
        />
        <MainGroupInput
          iconName="ios-card"
          placeholder={$t('address')}
          onChangeText={(text) => setAddress(text)}
          value={address}
        />
        <MainGroupInput
          iconName="ios-transgender"
          placeholder={$t('gender')}
          onChangeText={(text) => setGender(text)}
          value={gender}
        />
        <MainButton
          onPress={updateProfile}
          text={$t('screens.updateProfile.button').toUpperCase()}
          solid={canUpdateProfile}
        />
      </KeyboardAvoidingView>
    </View>
  )
}
const mapState = (state) => ({ state })

export default connect(mapState, { setLoading })(UpdateProfileScreen)
const styles = StyleSheet.create({
  container: {
    paddingTop: 5,
    flex: 1,
    backgroundColor: Colors.white,
  },
  avatarContainer: {
    alignItems: 'center',
  },
  avatar: {
    borderColor: Colors.secondary,
    borderWidth: 5,
    width: 100,
    height: 100,
    borderRadius: 120,
    alignItems: 'center',
    justifyContent: 'center',
  },
  avatarImage: {
    height: 50,
    resizeMode: 'contain',
  },
  groupPhone: {
    alignItems: 'center',
    marginVertical: 10,
  },
  userphone: {
    fontWeight: 'bold',
  },
})
