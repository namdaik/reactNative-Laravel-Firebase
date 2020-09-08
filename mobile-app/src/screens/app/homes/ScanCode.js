import React, { useState, useEffect } from 'react'
import { View, Text, TouchableOpacity, StyleSheet, ToastAndroid } from 'react-native'
import { useIsFocused } from '@react-navigation/native'
import { askAsync, CAMERA } from 'expo-permissions'
import { get as _get } from 'lodash'
import { BarCodeScanner } from 'expo-barcode-scanner'
import { connect } from 'react-redux'
import { setLoading } from '../../../actions'
import Colors from '../../../constants/colors'
const ScanCodeScreen = ({ navigation, setLoading }) => {
  const focused = useIsFocused()
  const [hasCameraPermisson, setCameraPermisson] = useState(false)
  useEffect(() => {
    ;(async () => {
      const { status } = await askAsync(CAMERA)
      setCameraPermisson(status === 'granted')
      if (status !== 'granted') {
        navigation.navigate('Home')
      }
    })()
  }, [])
  const searchOrder = (order_id) => {
    setLoading(true)
    axios
      .get('/search-order', { params: { order_id } })
      .then((response) => _get(response, 'data.result.success'))
      .then(({ order }) => {
        navigation.navigate('ShowOrder', { order })
      })
      .catch(() => {
        navigation.navigate('Home')
        ToastAndroid.showWithGravity(
          $t('commons.orderNotFound'),
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      })
      .finally(() => setLoading(false))
  }

  if (!hasCameraPermisson || !focused) {
    return <View />
  }
  return (
    <View style={styles.container}>
      <BarCodeScanner
        onBarCodeScanned={({ data }) => searchOrder(data)}
        style={styles.scanner}
      >
        <View style={styles.layerTop} />
        <View style={styles.layerCenter}>
          <View style={styles.layerLeft} />
          <View style={styles.focused} />
          <View style={styles.layerRight} />
        </View>
        <View style={styles.layerBottom}>
          <Text style={styles.hint}>{$t('screens.scanCode.hint')}</Text>
          <TouchableOpacity onPress={() => navigation.navigate('Home')}>
            <Text style={styles.canceler}>{$t('commons.cancel')}</Text>
          </TouchableOpacity>
        </View>
      </BarCodeScanner>
    </View>
  )
}
const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.black,
  },
  canceler: {
    color: Colors.white,
    marginTop: 22,
    fontSize: 22,
  },
  hint: {
    textAlign: 'center',
    color: Colors.white,
    fontWeight: '100',
  },
  scanner: {
    flex: 1,
    flexDirection: 'column',
  },
  layerTop: {
    flex: 2,
    backgroundColor: Colors.scanOpacity,
  },
  layerCenter: {
    flex: 2.3,
    flexDirection: 'row',
  },
  layerLeft: {
    flex: 1,
    backgroundColor: Colors.scanOpacity,
  },
  focused: {
    flex: 5,
  },
  layerRight: {
    flex: 1,
    backgroundColor: Colors.scanOpacity,
  },
  layerBottom: {
    alignItems: 'center',
    flex: 1.3,
    padding: 40,
    justifyContent: 'flex-end',
    backgroundColor: Colors.scanOpacity,
  },
})
export default connect(null, { setLoading })(ScanCodeScreen)
