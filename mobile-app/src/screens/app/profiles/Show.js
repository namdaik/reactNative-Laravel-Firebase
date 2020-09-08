import React, { useState } from 'react'
import { StyleSheet, View, ScrollView, ToastAndroid } from 'react-native'
import { get as _get } from 'lodash'

import { MainButton, MainGroupInput, MainCheckBox, MainHeader, SwithLang } from '../../../components'
import Colors from '../../../constants/colors'

import { setLoading, setCurentUser, setAuth } from '../../../actions'
import { connect } from 'react-redux'
import { Avatar } from 'react-native-elements'
import { toSortName } from '../../../helpers/string'
import * as ImagePicker from 'expo-image-picker'
import * as Permissions from 'expo-permissions'

const ProfileScreen = ({ setCurentUser, navigation, setLoading, state }) => {
  let user = _get(state, 'auth.user', {})
  const [fullName, setFullName] = useState(user.name)
  const [phone] = useState(user.phone)
  const [gender, setGender] = useState(user.gender)
  const [address, setAddress] = useState(user.address)
  const [email, setEmail] = useState(user.email)
  const [avatar, setAvatar] = useState(user.avatar)
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

  const toGenderText = (gender) => {
    if (gender == 0) {
      return $t('commons.woman')
    } else if (gender == 1) {
      return $t('commons.man')
    }
    return 'unknow'
  }
  const changeAccountInfo = () => {
    const data = {
      name: fullName,
      email: email,
      address: address,
      avatar: avatar,
      gender: gender?1:0
    }
    setLoading(true)
    axios.put('auth/profile/user', data).then((response) => {
      setCurentUser({user:response.data?.success?.user});
      ToastAndroid.showWithGravity(
        $t('screens.profile.updateSuccess'),
        ToastAndroid.SHORT,
        ToastAndroid.CENTER
      )
    })
    .catch(({response}) => {console.log(response.data.result)})
    .finally(()=>setLoading(false))
  }
  return (
    <View style={styles.container}>
      <MainHeader goBack={() => navigation.navigate('Home')}
        title={$t('screens.profile.title')}
        rightComponent={
          <SwithLang />
        }/>
      <View style={{ alignItems: 'center', paddingVertical: 10 }}>
        <Avatar
          source={{ uri: avatar }}
          title={toSortName(fullName)}
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
        }}
      />

      <MainGroupInput iconName="ios-call" value={phone} editable={false} />
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
            value={gender == 1}
            title={toGenderText(1)}
            onPress={() => setGender(1)}
          />
        </View>
        <View style={{ flex: 1 }}>
          <MainCheckBox
            round
            title={toGenderText(0)}
            value={gender == 0}
            onPress={() => setGender(0)}
          />
        </View>
      </View>
      <View style={{ marginVertical: 20 }}>
        <MainButton
          onPress={changeAccountInfo}
          text={$t('screens.profile.changeAccountInfo').toUpperCase()}
          enable={email && address && fullName }
        />
      </View>
    </View>
  )
}
const mapState = (state) => ({ state })
export default connect(mapState, { setLoading, setCurentUser, setAuth })(ProfileScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: '5%',
    backgroundColor: Colors.white,
  },
  genderContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between'
  },
  userInfo: {
    alignItems: 'center',
  },
  userName: {
    fontWeight: 'bold',
    fontSize: 18,
    color: Colors.black,
  },
  userEmail: {
    color: Colors.secondary,
  },
  listOrderCount: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    height: 40,
    marginVertical: 10,
  },
  itemOrderCount: {
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center',
  },
  orderNumber: {
    color: Colors.primary,
    fontWeight: 'bold',
    fontSize: 18,
    marginBottom: 5,
  },
  orderListWall: {
    width: 2,
    backgroundColor: Colors.secondary,
  },
  orderHistory: {
    marginVertical: 5,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
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
  mainProfileItem: {
    flexDirection: 'row',
    marginVertical: 10,
  },
  mainProfileIcon: {
    marginRight: 10,
  },
})
