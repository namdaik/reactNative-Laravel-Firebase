import React, { useState } from 'react'
import Colors from '../../constants/colors'
import { connect } from 'react-redux'
import { Icon, Overlay, Avatar } from 'react-native-elements'
import {
  ToastAndroid,
  View,
  StyleSheet,
  TouchableOpacity,
  Text,
} from 'react-native'
import { setAppLocale } from '../../actions'

const SwithLang = ({ setAppLocale, iconSize, themWhiete }) => {
  const [open, setOpen] = useState(false)
  const swithLang = (lang) => {
    try {
      setAppLocale(lang)
      ToastAndroid.showWithGravity(
        $t('commons.swithLangSuccess'),
        ToastAndroid.SHORT,
        ToastAndroid.CENTER
      )
    } catch (error) {
      ToastAndroid.showWithGravity(
        $t('commons.swithLangFail'),
        ToastAndroid.SHORT,
        ToastAndroid.CENTER
      )
    } finally {
      setOpen(false)
    }
  }

  return (
    <View style={styles.container}>
      <Icon
        color={themWhiete?Colors.white:Colors.primary}
        size={iconSize || 22}
        name={'g-translate'}
        onPress={() => setOpen(true)}
      />
      <Overlay
        width={320}
        height={100}
        isVisible={open}
        onBackdropPress={() => setOpen(false)}
      >
        <View style={styles.Langs}>
          <TouchableOpacity
            onPress={() => swithLang('en-US')}
            style={styles.lang}
          >
            <Avatar
              containerStyle={{marginRight: 10}}
              source={require('../../assets/images/flags/en.png')}
              size={21}
              />
            <Text>EngLish</Text>
          </TouchableOpacity>
          <TouchableOpacity
            onPress={() => swithLang('vi-VN')}
            style={styles.lang}
            >
            <Avatar
              containerStyle={{marginRight: 10}}
              source={require('../../assets/images/flags/vn.png')}
              size={21}
            />
            <Text>Tiếng Việt</Text>
          </TouchableOpacity>
        </View>
      </Overlay>
    </View>
  )
}


export default connect(null, { setAppLocale })(SwithLang)

const styles = StyleSheet.create({
  langs: {
    alignItems: 'center',
    justifyContent: 'center',
  },
  lang: {
    width: 150,
    paddingVertical: 10,
    flexDirection: 'row',
  },
})
