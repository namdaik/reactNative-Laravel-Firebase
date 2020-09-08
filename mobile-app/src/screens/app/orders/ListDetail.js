import React, { useState, useEffect } from 'react'
import {
  StyleSheet,
  Text,
  View,
  TouchableOpacity,
  ActivityIndicator,
  ScrollView,
  ToastAndroid,
} from 'react-native'
import { setLoading } from '../../../actions'
import { Icon } from 'react-native-elements'
import { connect } from 'react-redux'
import { get as _get } from 'lodash'
import Colors from '../../../constants/colors'
import { statusToOrderIcon, toOrderStatusKey } from '../../../helpers/string'
import { MainHeader } from '../../../components'

const ListAll = ({ navigation, setLoading, route }) => {
  const { status } = route.params
  const [orders, setOrders] = useState([])
  const [curentPage, setCurentPage] = useState(0)
  const [lastPage, setLastPage] = useState(1)
  const [loadMore, setLoadMore] = useState(false)
  const fetchOrdersFromApi = (limit = 5) => {
    if (curentPage === lastPage || loadMore) {
      return
    }
    setLoadMore(true)
    let params = {
      limit,
      page: curentPage + 1,
      status,
    }
    axios
      .get('user/orders', { params })
      .then(({ data }) => {
        const res = _get(data, 'result.success.orders', {})
        if (res.total == 0) {
          ToastAndroid.showWithGravity(
            'Không tìm thấy đơn hàng nào',
            ToastAndroid.SHORT,
            ToastAndroid.CENTER
          );
          return
        }
        setOrders([...orders, ...res.data])
        setCurentPage(res.current_page)
        setLastPage(res.last_page)
      })
      .catch((e) =>
        ToastAndroid.showWithGravity(
          'Không tìm thấy đơn hàng nào',
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        ))
      .finally(() => {
        setLoadMore(false)
      })
  }
  useEffect(() => {
    const initOrder = async () => {
      setLoading(true)
      await fetchOrdersFromApi()
      setLoading(false)
    }
    initOrder()
  }, [])

  const RenderFooter = () => {
    if (!loadMore) return null
    return (
      <ActivityIndicator style={{ flex: 1, color: Colors.primary }} size={22} />
    )
  }

  return (
    <View style={{ flex: 1 }}>
      <MainHeader goBack={()=>navigation.goBack()} title={$t(toOrderStatusKey(status))} />
      <ScrollView
        scrollEventThrottle={2}
        onScroll={({ nativeEvent }) => {
          if (isPositionBottom(nativeEvent)) {
            fetchOrdersFromApi()
          }
        }}
      >
        {orders.map((item, i) => {
          return (
            <EachOrder
              key={i}
              data={item}
              onPress={() => navigation.navigate('ShowOrder', { order: item, canBack:true })}
            />
          )
        })}
        <RenderFooter />
      </ScrollView>
    </View>
  )
}

function EachOrder({ data, onPress }) {
  return (
    <TouchableOpacity style={styles.option} onPress={onPress}>
      <View style={{ flexDirection: 'row' }}>
        <View style={styles.optionIconContainer}>
          <Icon {...statusToOrderIcon(data.status)} />
        </View>
        <View style={styles.optionTextContainer}>
          <Text style={styles.optionText}>{data.id}</Text>
        </View>
      </View>
      <View style={styles.receiverContainer}>
        <Text style={styles.receiverName}>{data.receivers.name}</Text>
        <View style={styles.receiverInfo}>
          <Icon
            name="phone"
            color={Colors.secondary}
            size={18}
            style={{ marginRight: 5 }}
          />
          <Text style={{ color: Colors.secondary }}>
            {data.receivers.phone}
          </Text>
        </View>
        <View style={styles.receiverInfo}>
          <Icon
            name="room"
            color={Colors.secondary}
            size={18}
            style={{ marginRight: 5 }}
          />
          <Text
            style={{ color: Colors.secondary }}
          >{`${data.receivers.address}, ${data.receivers.ward.name}, ${data.receivers.ward.district.name}, ${data.receivers.ward.district.province.name}`}</Text>
        </View>
      </View>
    </TouchableOpacity>
  )
}

const styles = StyleSheet.create({
  receiverInfo: {
    flexDirection: 'row',
    marginTop: 5,
  },
  container: {
    flex: 1,
    backgroundColor: '#fafafa',
  },
  contentContainer: {
    paddingTop: 15,
  },
  optionIconContainer: {
    marginRight: 12,
  },
  option: {
    backgroundColor: '#fdfdfd',
    paddingHorizontal: 15,
    paddingVertical: 15,
    marginBottom: 10,
    marginHorizontal: 10,
    borderRadius: 10,
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

const isPositionBottom = ({
  layoutMeasurement,
  contentOffset,
  contentSize,
}) => {
  return layoutMeasurement.height + contentOffset.y >= contentSize.height - 30
}
export default connect(null, { setLoading })(ListAll)
