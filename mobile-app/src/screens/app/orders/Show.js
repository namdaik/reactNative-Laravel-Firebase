import React, { useState } from 'react'
import { StyleSheet, ScrollView, View } from 'react-native'
import { ListItem, Text } from 'react-native-elements'
import {
  MainHeader,
  MainQRCode,
  ShippingHistoriesProcess,
} from '../../../components'
import { toOrderStatusKey } from '../../../helpers/string'
import Colors from '../../../constants/colors'
import { get as _get } from 'lodash'
import { connect } from 'react-redux'
import { setLoading } from '../../../actions'
const ShowOrderScreen = ({ navigation, route, state, setLoading }) => {
  const [showQR, setShowQR] = useState(false)
  const { order, canBack } = route.params
  if (order) {
    const sender = {
      header: $t('commons.sender'),
      name: _get(order, 'place_of_shipment.name'),
      phone: _get(order, 'place_of_shipment.phone'),
      address: `${_get(order, 'place_of_shipment.address') || ''}, ${
        _get(order, 'place_of_shipment.ward.name') || ''
      }, ${_get(order, 'place_of_shipment.ward.district.name') || ''}, ${
        _get(order, 'place_of_shipment.ward.district.province.name') || ''
      }`,
    }
    const receiver = {
      header: $t('commons.receiver'),
      name: _get(order, 'receivers.name'),
      phone: _get(order, 'receivers.phone'),
      address: `${_get(order, 'receivers.address')}, ${
        _get(order, 'receivers.ward.name') || ''
      }, ${_get(order, 'receivers.ward.district.name') || ''}, ${
        _get(order, 'receivers.ward.district.province.name') || ''
      }`,
    }
    const histories = _get(order, 'shipping_histories')
    return (
      <View style={styles.container}>
        <MainHeader
          backgroundColor={Colors.inputBackground}
          goBack={() => canBack?navigation.goBack():navigation.navigate('Home')}
          title={$t('screens.showOrder.title')}
        />
        <ScrollView contentContainerStyle={{ paddingHorizontal: '5%' }}>
          <View style={styles.groupInfor}>
            <Text>{$t('commons.order')}</Text>
            <ListItem
              containerStyle={styles.firstListItem}
              rightIcon={{
                name: 'qrcode',
                type: 'font-awesome',
                onPress: () => setShowQR(true),
              }}
              bottomDivider
              title={$t('commons.orderId') + ': ' + order.id}
            />
            <ListItem
              title={$t('commons.orderStatus.title')}
              rightTitle={$t(toOrderStatusKey(order.status))}
              rightContentContainerStyle={{ flex: 1.2 }}
              topDivider
              bottomDivider
            />
            <ListItem
              title={$t('commons.weight')}
              rightTitle={`${order.parcel_weight / 1000} (Kg)`}
              topDivider
              bottomDivider
            />
            <ListItem
              title={$t('commons.orderSize')}
              rightTitle={`${order.parcel_length}x${order.parcel_width}x${order.parcel_height} (cm)`}
              topDivider
              bottomDivider
            />
            <ListItem
              title={$t('commons.note')}
              rightTitle={order.note || $t('commons.empty')}
              topDivider
              bottomDivider
              rightContentContainerStyle={{ flex: 3 }}
            />
            <ListItem
              containerStyle={styles.lastListItem}
              title={$t('commons.description')}
              rightTitle={order.parcel_description || $t('commons.empty')}
              topDivider
              rightContentContainerStyle={{ flex: 3 }}
            />
          </View>
          <Person info={sender} />
          <Person info={receiver} />
          <ShippingHistoriesProcess content={histories} />
        </ScrollView>
        <MainQRCode
          isShow={showQR}
          onBackdropPress={() => setShowQR(false)}
          code={order.id}
        />
      </View>
    )
  }
  return <></>
}

const Person = ({ info }) => {
  if (info) {
    const { name, phone, address, header } = info
    return (
      <View style={styles.groupInfor}>
        <Text>{header}</Text>
        <ListItem
          containerStyle={styles.firstListItem}
          title={$t('commons.name')}
          rightTitle={name}
          rightContentContainerStyle={{ flex: 2 }}
          bottomDivider
        />
        <ListItem
          title={$t('commons.phoneNumber')}
          rightTitle={phone}
          rightContentContainerStyle={{ flex: 2 }}
          topDivider
          bottomDivider
        />
        <ListItem
          title={$t('commons.address')}
          containerStyle={styles.lastListItem}
          rightTitle={`${address}`}
          rightContentContainerStyle={{ flex: 3 }}
          topDivider
        />
      </View>
    )
  }
  return <></>
}

const mapState = (state) => ({ state })
export default connect(mapState, { setLoading })(ShowOrderScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.inputBackground,
  },
  groupInfor: {
    paddingVertical: 10,
  },
  value: {
    fontWeight: 'bold',
  },
  lastListItem: {
    borderBottomLeftRadius: 10,
    borderBottomRightRadius: 10,
  },
  firstListItem: {
    borderTopLeftRadius: 10,
    borderTopRightRadius: 10,
  },
})
