import React, { useState, useEffect } from 'react'
import {
  StyleSheet,
  Text,
  TouchableOpacity,
  View,
  ScrollView,
  TextInput,
  Vibration,
  ToastAndroid,
  ActivityIndicator,
} from 'react-native'
import { Icon, Avatar } from 'react-native-elements'
import { connect } from 'react-redux'
import { get as _get } from 'lodash'
import { Notifications } from 'expo'
import Colors from '../../../constants/colors'
import { toSortName } from '../../../helpers/string'
import { setAuth, setLoading } from '../../../actions'
import moment from 'moment'
import { SwithLang } from '../../../components'

const HomeScreen = ({ setAuth, setLoading, state, navigation }) => {
  const curentUser = state.auth.user
  const [keyWord, setKeyWord] = useState()
  const [logingOut, setLogingOut] = useState(false)

  useEffect(() => {
    Notifications.addListener(({ data }) => {
      searchOrder(data.id)
      Vibration.vibrate([0, 250, 0, 250])
    })
  }, [])

  const clock = () => {
    let ddd = $t(`calendar.th.${nowFormat('ddd')}`)
    return `${ddd}, ${nowFormat()}`
  }

  const searchOrder = async (order_id) => {
    setLoading(true)
    axios
      .get('/search-order', { params: { order_id } })
      .then(({ data }) => _get(data, 'result.success'))
      .then(({ order }) => {
        navigation.navigate('ShowOrder', { order })
      })
      .catch((e) => {
        ToastAndroid.showWithGravity(
          $t('commons.orderNotFound'),
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      })
      .finally(() => setLoading(false))
  }

  const nowFormat = (type = 'DD/MM/YYYY') => {
    return moment().format(type).toLocaleLowerCase()
  }

  const logout = async () => {
    setLogingOut(true)
    let mobile_token = await Notifications.getExpoPushTokenAsync()
    axios
      .get('user/logout', { params: { mobile_token } })
      .then(() => setAuth(null))
      .finally(() => setLogingOut(false))
  }

  return (
    <View style={styles.container}>
      <View style={styles.mainBox}>
        <View style={styles.header}>
          <View style={styles.headerLeft}>
            <Avatar
              title={toSortName(curentUser.name)}
              source={{ uri: curentUser.avatar }}
              rounded
              size={45}
              containerStyle={{ marginRight: 10 }}
              onPress={() => navigation.navigate('Profile')}
            />
            <View style={styles.headerInfor}>
              <View style={styles.headerWelcome}>
                <Text style={styles.headerWelcomeUserName}>
                  {curentUser.name}
                </Text>
              </View>
              <View style={styles.headerClock}>
                <Text style={styles.headerClockContent}>{clock()}</Text>
              </View>
            </View>
          </View>
          <SwithLang themWhiete />
          <TouchableOpacity onPress={logout} style={styles.headerRight}>
            {!logingOut ? (
              <Icon size={23} name="exit-to-app" color={Colors.white} />
            ) : (
              <ActivityIndicator color={Colors.white} size={23} />
            )}
          </TouchableOpacity>
        </View>
        <View style={styles.body}>
          <View style={styles.bodyTOp}>
            <View style={styles.hint}>
              <View style={{ flexDirection: 'row' }}>
                <Text style={styles.appName}>{APP_NAME.toUpperCase()}</Text>
              </View>
              <Text style={styles.slogan}>{$t('commons.appHint')}</Text>
            </View>
            <View style={styles.searchGroup}>
              <View style={styles.searchBoxLeft}>
                <Icon
                  name="search"
                  type="font-awesome"
                  color={Colors.secondary}
                  size={25}
                  style={styles.searchIcon}
                  onPress={() => searchOrder(keyWord)}
                />
                <TextInput
                  style={styles.searchInput}
                  onChangeText={(text) => setKeyWord(text)}
                  placeholder={$t('commons.orderCode')}
                />
              </View>
              <View style={styles.searchBoxRight}>
                <TouchableOpacity
                  onPress={() => navigation.navigate('ScanCode')}
                >
                  <Icon
                    name="qrcode"
                    type="font-awesome"
                    color={Colors.secondary}
                    size={25}
                    style={styles.scanQR}
                  />
                </TouchableOpacity>
              </View>
            </View>
          </View>
        </View>
      </View>
      <View style={styles.serviceBox}>
        <View style={styles.serviceHeader}>
          <Text style={styles.serviceText}>{$t('commons.service')}</Text>
          <Text style={styles.serviceMore}>{$t('commons.seeMore')}</Text>
        </View>
        <View style={styles.serviceBody}>
          <ScrollView
            style={styles.serviceList}
            horizontal
            showsHorizontalScrollIndicator={false}
          >
            <View style={styles.serviceItem}></View>
            <View style={styles.serviceItem}></View>
            <View style={styles.serviceItem}></View>
            <View style={styles.serviceItem}></View>
          </ScrollView>
        </View>
      </View>
    </View>
  )
}
const mapState = (state) => ({ state })
export default connect(mapState, { setAuth, setLoading })(HomeScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.white,
  },
  mainBox: {
    flex: 0.8,
    paddingTop: 30,
    paddingHorizontal: '5%',
    backgroundColor: Colors.primary,
    borderBottomLeftRadius: 40,
    borderBottomRightRadius: 40,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 15,
  },
  headerLeft: {
    flex: 0.9,
    flexDirection: 'row',
  },
  headerWelcome: {
    flexDirection: 'row',
  },
  headerWelcomeText: {
    color: Colors.white,
  },
  headerWelcomeUserName: {
    color: Colors.white,
  },
  headerClockContent: {
    color: Colors.white,
  },
  headerInfor: {
    justifyContent: 'flex-end',
  },
  headerRight: {
    flex: 0.1,
    alignItems: 'flex-end',
  },
  hint: {
    justifyContent: 'center',
    alignItems: 'center',
    marginHorizontal: 10,
  },
  appName: {
    fontWeight: 'bold',
    color: Colors.white,
    fontSize: 20,
  },
  slogan: {
    color: Colors.white,
  },
  searchGroup: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    backgroundColor: Colors.white,
    borderRadius: 15,
    alignItems: 'center',
    paddingHorizontal: 15,
    marginVertical: 20,
  },
  searchBoxLeft: {
    flex: 0.5,
    height: 45,
    flexDirection: 'row',
    alignItems: 'center',
  },
  searchIcon: {
    flex: 0.1,
    marginRight: 10,
  },
  searchInput: {
    width: '100%',
    height: 45,
    marginLeft: 10,
  },
  serviceBox: {
    flex: 0.5,
  },
  serviceHeader: {
    paddingHorizontal: '5%',
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: 15,
  },
  serviceList: {
    paddingHorizontal: '5%',
  },
  serviceItem: {
    width: 120,
    height: 120,
    borderRadius: 20,
    marginRight: 15,
    backgroundColor: Colors.paleGray,
  },
  serviceMore: {
    color: Colors.primary,
  },
})
