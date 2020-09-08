import React from 'react'
import { StyleSheet, View, ScrollView } from 'react-native'
import Colors from '../../../constants/colors'
import { ListItem } from 'react-native-elements'
import { MainHeader } from '../../../components'
import { statusToOrderIcon, toOrderStatusKey } from '../../../helpers/string'

const OrderLists = ({ navigation }) => {
  const lists = [
    { status: 0 },
    { status: 1 },
    { status: 2 },
    { status: 3 },
    { status: 4 },
    { status: 5 },
    { status: -1 },
  ]
  return (
    <View style={styles.container}>
      <MainHeader goBack={()=>navigation.navigate('ListDetail')} title={$t('commons.orderManager')}/>
      <ScrollView contentContainerStyle={styles.contentContainer}>
        {lists.map((item,i) => {
          return (
            <ListItem
              key={i}
              leftIcon={statusToOrderIcon(item.status)}
              bottomDivider
              chevron
              title={$t(toOrderStatusKey(item.status))}
              onPress={() =>
                navigation.navigate('ListDetail', { status: item.status })
              }
            />
          )
        })}
      </ScrollView>
    </View>
  )
}
const styles = StyleSheet.create({
  container: {
    backgroundColor: Colors.white,
  },
  contentContainer: {
    marginHorizontal: '5%',
    paddingTop: 15,
  },
  optionIconContainer: {
    marginRight: 12,
  },
  option: {
    backgroundColor: '#fdfdfd',
    paddingHorizontal: 15,
    paddingVertical: 15,
    borderWidth: StyleSheet.hairlineWidth,
    borderBottomWidth: 0,
    borderColor: '#ededed',
  },
  lastOption: {
    borderBottomWidth: StyleSheet.hairlineWidth,
  },
  optionText: {
    fontSize: 15,
    alignSelf: 'flex-start',
    marginTop: 1,
  },
})

export default OrderLists
