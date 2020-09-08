import React, { useState, useEffect } from 'react'
import {
  StyleSheet,
  View,
  ScrollView,
  ToastAndroid,
} from 'react-native'
import { get as _get } from 'lodash'

import {
  MainButton,
  MainHeader,
  MainCheckBox,
  MainGroupInput,
  SwithLang,
} from '../../components'
import Colors from '../../constants/colors'
import * as ImagePicker from 'expo-image-picker'
import * as Permissions from 'expo-permissions'
import { setLoading } from '../../actions'
import { connect } from 'react-redux'
import { Avatar } from 'react-native-elements'
import { toSortName } from '../../helpers/string'

const RegisterScreen = ({ setLoading, navigation, route }) => {
  const { otp, phone } = route.params
  const [fullName, setFullName] = useState('')
  const [password, setPassword] = useState('')
  const [gender, setGender] = useState(false)
  const [address, setAddress] = useState(null)
  const [email, setEmail] = useState(null)
  const [avatarTitle, setAvatarTitle] = useState('A')
  const [avatar, setAvatar] = useState(null)
  const [agree, setAgree] = useState(false)
  const [canRegister, setCanRegister] = useState(false)
  const pickAvatar = async () => {
    const { status } = await Permissions.askAsync(Permissions.CAMERA_ROLL)
    if (status !== 'granted') {
      return
    }
    try {
      let result = await ImagePicker.launchImageLibraryAsync({
        mediaTypes: ImagePicker.MediaTypeOptions.All,
        allowsEditing: true,
        aspect: [4, 3],
        quality: 1,
        base64: true,
      })
      if (!result.cancelled) {
        setAvatar(`data:image/png;base64, ${result.base64}`)
      }
    } catch (e) {
      console.log(e)
    }
  }

  useEffect(() => {
    setCanRegister(true)
  }, [fullName, password, agree])

  const register = async () => {
    setLoading(true)
    let params = {
      name: fullName,
      phone,
      password,
      password_confirmation: password,
      otp,
      gender,
      address,
      email,
      avatar,
    }
    axios
      .post('user/register', params)
      .then(() => {
        navigation.navigate('Login')
      })
      .catch(({response}) =>
      {
        console.log(response.data.result.errors);

        ToastAndroid.showWithGravity(
          'Please try again!',
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      }
      )
      .finally(() => {
        setLoading(false)
      })
  }

  return (
    <View style={styles.container}>
      <MainHeader
        goBack={() => navigation.push('Login')}
        title={$t('screens.register.title')}
        rightComponent={<SwithLang/>}
      />
      <ScrollView contentContainerStyle={{ paddingHorizontal: '5%' }}>
        <View style={{ alignItems: 'center', paddingVertical: 10 }}>
          <Avatar
            source={{ uri: avatar }}
            title={avatarTitle}
            showEditButton
            rounded
            size={100}
            onEditPress={pickAvatar}
          />
        </View>
        <MainGroupInput
          iconName="ios-person"
          name="fullName"
          rules="required"
          value={fullName}
          placeholder={$t('commons.fullName')}
          onChangeText={(text) => {
            setFullName(text)
            setAvatarTitle(toSortName(text))
          }}
        />

        <MainGroupInput iconName="ios-call" value={phone} editable={false} />
        <MainGroupInput
          iconName="ios-lock"
          name="password"
          rules="required"
          value={password}
          placeholder={$t('commons.password')}
          securable
          onChangeText={(text) => setPassword(text)}
        />
        <MainGroupInput
          iconName="ios-card"
          placeholder={$t('commons.address')}
          onChangeText={(text) => setAddress(text)}
          value={address}
        />
        <MainGroupInput
          iconName="ios-mail"
          placeholder={$t('commons.emailAddress')}
          onChangeText={(text) => setEmail(text)}
          value={email}
        />
        <View style={styles.genderContainer}>
            <View style={{ flex: 1 }}>
              <MainCheckBox
                round
                value={gender}
                title={' '+ $t('commons.man')}
                onPress={() => setGender(true)}
              />
            </View>
            <View style={{ flex: 1 }}>
              <MainCheckBox
                round
                value={!gender}
                title={' '+ $t('commons.woman')}
                onPress={() => setGender(false)}
              />
            </View>
          </View>
        <View style={styles.agreeStyle}>
          <MainCheckBox
            onPress={() => setAgree(!agree)}
            value={agree}
            title={$t('screens.register.agree')}
          />
        </View>
        <MainButton
          onPress={register}
          text={$t('commons.register').toUpperCase()}
          enable={canRegister}
        />
      </ScrollView>
    </View>
  )
}
const mapState = (state) => ({ state })

export default connect(mapState, { setLoading })(RegisterScreen)
const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.white,
  },
  agreeStyle: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  genderContainer: {
    flexDirection: 'row',
    marginBottom: 20
  }
})
