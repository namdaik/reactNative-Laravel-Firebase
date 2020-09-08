import React from 'react'
import { StyleSheet, Text, View } from 'react-native'
import Colors from '../../constants/colors'
import { get as _get } from 'lodash'
import { toOrderStatusKey } from '../../helpers/string'
import moment from 'moment'
const ShippingHistoriesProcess = ({ content }) => {
  const histories = content

  return (
    <View style={styles.container}>
      <Text style={styles.title}>{$t('commons.orderHistories')}</Text>
      {histories.map((history, i) => {
        const itemStyles =
          i === histories.length - 1 ? lastItem : i <= 0 ? firstItem : midItem
        return (
          <View style={itemStyles.block} key={i}>
            <View style={itemStyles.line}>
              <View style={itemStyles.doted} />
            </View>
            <Text>{`${$t(toOrderStatusKey(history.order_status))} ${moment(history.created_at).format('hh:mm - DD/MM/YYYY')}`}</Text>
          </View>
        )
      })}
    </View>
  )
}
export default ShippingHistoriesProcess

const firstItem = StyleSheet.create({
  block: {
    minHeight: 50,
    justifyContent: 'flex-start',
    paddingLeft: 30,
  },
  line: {
    position: 'absolute',
    width: 3,
    height: '100%',
    backgroundColor: Colors.primary,
    alignItems: 'center',
  },
  doted: {
    position: 'absolute',
    backgroundColor: Colors.primary,
    width: 20,
    height: 20,
    borderWidth: 3,
    borderColor: Colors.primary,
    borderRadius: 10,
  },
})
const midItem = StyleSheet.create({
  block: {
    minHeight: 100,
    justifyContent: 'center',
    paddingLeft: 30,
  },
  line: {
    position: 'absolute',
    width: 3,
    height: '100%',
    backgroundColor: Colors.primary,
    alignItems: 'center',
  },
  doted: {
    position: 'absolute',
    transform: [{ translateY: -10 }],
    top: '50%',
    backgroundColor: Colors.primary,
    width: 20,
    height: 20,
    borderWidth: 3,
    borderColor: Colors.primary,
    borderRadius: 10,
  },
})

const lastItem = StyleSheet.create({
  block: {
    minHeight: 50,
    justifyContent: 'flex-end',
    paddingLeft: 30,
  },
  line: {
    position: 'absolute',
    width: 3,
    height: '100%',
    backgroundColor: Colors.primary,
    alignItems: 'center',
  },
  doted: {
    position: 'absolute',
    bottom: 0,
    backgroundColor: Colors.inputBackground,
    width: 30,
    height: 30,
    borderWidth: 3,
    borderColor: Colors.primary,
    borderRadius: 15,
  },
})
const styles = StyleSheet.create({
  container: {
    margin: '5%',
  },
  title: {
    marginBottom: 10,
  },
})
