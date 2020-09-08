import React, { useState, useEffect } from 'react'
import { StyleSheet, ScrollView, View, TouchableOpacity, ToastAndroid } from 'react-native'
import { Icon, Text, Overlay } from 'react-native-elements'
import {
  MainGroupInput,
  MainHeader,
  MainCheckBox,
  MainButton,
} from '../../../components'
import Colors from '../../../constants/colors'
import { get as _get } from 'lodash'
import { connect } from 'react-redux'
import HandleShippingCost from '../../../helpers/shipping-cost-caculate'
import MainSelectAddress from '../../../components/main-select-address'
import { setLoading } from '../../../actions'
const CreateOrderScreen = ({ navigation, state, setLoading }) => {
  const [placeOfShipments, setPlaceOfShipments] = useState([])
  const [placeId, setPlaceId] = useState()
  const [showChosePlace, setShowChosePlace] = useState(false)
  const [chosedPlace, setChosedPlace] = useState(false)

  const [senderName, setSenderName] = useState()
  const [senderPhone, setSenderPhone] = useState()
  const [senderAddress, setSenderAddress] = useState()
  const [senderProvince, setSenderProvince] = useState({})
  const [senderDistrict, setSenderDistrict] = useState({})
  const [senderWard, setSenderWard] = useState({})

  const handleChosePlace = (p) => {
    setChosedPlace(true)
    setPlaceId(p.id)
    setSenderName(p.name)
    setSenderPhone(p.phone)
    setSenderAddress(p.address)
    setSenderProvince(_get(p, 'ward.district.province'))
    setSenderDistrict(_get(p, 'ward.district'))
    setSenderWard(_get(p, 'ward'))
    setShowChosePlace(false)
  }
  const [receiverName, setReceiverName] = useState('')
  const [receiverPhone, setReceiverPhone] = useState('')
  const [receiverAddress, setReceiverAddress] = useState('')
  const [receiverProvince, setReceiverProvince] = useState({})
  const [receiverDistrict, setReceiverDistrict] = useState({})
  const [receiverWard, setReceiverWard] = useState({})

  const [productWeight, setProductWeight] = useState('')
  const [productLength, setProductLength] = useState('')
  const [productWidth, setProductWidth] = useState('')
  const [productHeight, setProductHeight] = useState('')
  const [productNote, setProductNote] = useState('')
  const [productDescription, setProductDescription] = useState('')
  const [cost, setCost] = useState(0)

  const [isPay, setIsPay] = useState(true)
  const [costCaculateable, setCostCaculateable] = useState(false)
  const [canSubmit, setCanSubmit] = useState(false)
  const [weightError, setWeightError] = useState('')

  const fetchTop5PlaceOfShipment = () => {
    axios
      .get('user/order/show-top5-place-of-shipment')
      .then(({ data }) => {
        setPlaceOfShipments(_get(data, 'result.success.place_of_shipments', []))
      })
      .catch((e) => {
        console.log(e)
        setPlaceOfShipments([])
      })
  }
  useEffect(() => {
    fetchTop5PlaceOfShipment()
  }, [])
  useEffect(() => {
    showPrice()
  }, [
    senderProvince,
    receiverProvince,
    productWeight,
    productLength,
    productWidth,
    productHeight,
  ])

  useEffect(() => {
    setCanSubmit(
      senderName &&
        senderPhone &&
        receiverName &&
        receiverPhone &&
        costCaculateable
    )
  }, [senderName, senderPhone, receiverName, receiverPhone, costCaculateable])

  const showPrice = () => {
    try {
      let sippingCost = new HandleShippingCost(
        senderProvince,
        receiverProvince,
        {
          weight: productWeight,
          width: productWidth,
          length: productLength,
          height: productHeight,
        }
      )
      setCost(sippingCost.estimate)
      setCostCaculateable(true)
      setWeightError('')
    } catch (error) {
      if (error.key === 'maxWeightOrder') {
        setWeightError(error.message)
      }
      setCost(0)
      setCostCaculateable(false)
    }
  }

  const handleConfirmOrder = () => {
    let data = {
      receivers: {
        name: receiverName,
        address: receiverAddress,
        phone: receiverPhone,
        ward: receiverWard.id,
      },
      price: cost,
      parcel_weight: productWeight,
      parcel_length: productLength,
      parcel_width: productWidth,
      parcel_height: productHeight,
      parcel_description: productDescription,
      note: productNote,
      is_paid: isPay,
    }
    if (chosedPlace) {
      data.place_of_shipment_id = placeId
    } else {
      data.place_of_shipment = {
        name: senderName,
        address: senderAddress,
        phone: senderPhone,
        province_id: senderProvince.id,
        district_id: senderDistrict.id,
        ward_id: senderWard.id,
      }
    }
    setLoading(true)
    axios
      .post('user/order', data)
      .then(({ data }) => {
        const order = _get(data, 'result.success.order')
        navigation.navigate('ShowOrder', { order })
      })
      .catch(({ response }) => {
       let e = _get(response, 'data.result.errors')
      if (e) {
        ToastAndroid.showWithGravity(
          e[Object.keys(e)[0]][0],
          ToastAndroid.SHORT,
          ToastAndroid.CENTER
        )
      }
      })
      .finally(() => setLoading(false))
  }
  return (
    <View style={styles.container}>
      <MainHeader
        goBack={() => navigation.goBack()}
        title={$t('screens.createOrder.title')}
      />
      <ScrollView>
        <InfoGroup
          chosePlace
          chosedPlace={chosedPlace}
          chosePlacePress={() => setShowChosePlace(true)}
          createPlace={() => {
            setChosedPlace(false)
            setSenderName('')
            setSenderAddress('')
            setSenderPhone('')
          }}
          textTitle="screens.createOrder.senderInfor"
          iconTitleName="ios-person"
        >
          <MainGroupInput
            value={senderName}
            name={'fullName'}
            editable={!chosedPlace}
            rules="required"
            iconName="ios-person"
            placeholder={$t('commons.fullName')}
            onChangeText={(text) => setSenderName(text)}
          />
          <MainGroupInput
            value={senderPhone}
            name="phone"
            rules="required"
            editable={!chosedPlace}
            iconName="ios-call"
            placeholder={$t('commons.phoneNumber')}
            onChangeText={(text) => setSenderPhone(text)}
          />
          {!chosedPlace ? (
            <View>
              <MainSelectAddress
                selectedProvince={(p) => setSenderProvince(p)}
                selectedDistrict={(d) => setSenderDistrict(d)}
                selectedWard={(w) => setSenderWard(w)}
              />
              <MainGroupInput
                value={senderAddress}
                name="addressDetail"
                rules="required"
                iconName="ios-card"
                placeholder={$t('commons.addressDetail')}
                onChangeText={(text) => setSenderAddress(text)}
              />
            </View>
          ) : (
            <View>
              <MainGroupInput
                value={`${senderAddress}, ${senderWard.name}, ${senderDistrict.name}, ${senderProvince.name}`}
                iconName="ios-card"
                editable={false}
                onChangeText={() => null}
              />
            </View>
          )}
        </InfoGroup>
        <InfoGroup
          textTitle="screens.createOrder.receiverInfor"
          iconTitleName="ios-person"
        >
          <MainGroupInput
            value={receiverName}
            name={'full_name'}
            rules="required"
            iconName="ios-person"
            placeholder={$t('commons.fullName')}
            onChangeText={(text) => setReceiverName(text)}
          />
          <MainGroupInput
            value={receiverPhone}
            name="phone"
            rules="required"
            iconName="ios-call"
            placeholder={$t('commons.phoneNumber')}
            onChangeText={(text) => setReceiverPhone(text)}
          />
          <MainSelectAddress
            selectedProvince={(p) => setReceiverProvince(p)}
            selectedDistrict={(d) => setReceiverDistrict(d)}
            selectedWard={(w) => setReceiverWard(w)}
          />
          <MainGroupInput
            value={receiverAddress}
            name="addressDetail"
            rules="required"
            iconName="ios-card"
            placeholder={$t('commons.addressDetail')}
            onChangeText={(text) => setReceiverAddress(text)}
          />
        </InfoGroup>
        <InfoGroup
          textTitle="screens.createOrder.productInfor"
          iconTitleName="ios-cube"
        >
          <MainGroupInput
            value={`${productWeight}`}
            name="weight"
            error={weightError}
            rules="required|numeric"
            dataType="numeric"
            type="number-pad"
            iconName="ios-archive"
            placeholder={$t('commons.weight') + ' (g)'}
            onChangeText={(text) => setProductWeight(text)}
          />
          <MainGroupInput
            value={`${productLength}`}
            name="length"
            rules="required|numeric|max:80"
            dataType="numeric"
            type="number-pad"
            iconName="ios-cube"
            placeholder={$t('commons.length') + ' (cm)'}
            onChangeText={(text) => setProductLength(text)}
          />
          <MainGroupInput
            value={`${productWidth}`}
            name="width"
            rules="required|numeric|max:80"
            dataType="numeric"
            type="number-pad"
            iconName="ios-cube"
            placeholder={$t('commons.width') + ' (cm)'}
            onChangeText={(text) => setProductWidth(text)}
          />
          <MainGroupInput
            value={`${productHeight}`}
            name="width"
            rules="required|numeric|max:80"
            dataType="numeric"
            type="number-pad"
            iconName="ios-cube"
            placeholder={$t('commons.height') + ' (cm)'}
            onChangeText={(text) => setProductHeight(text)}
          />
          <MainGroupInput
            resizeable
            value={productNote}
            iconName="ios-bookmark"
            placeholder={$t('commons.note')}
            onChangeText={(text) => setProductNote(text)}
          />
          <MainGroupInput
            resizeable
            value={productDescription}
            iconName="ios-book"
            iconType="ionicon"
            placeholder={$t('commons.description')}
            onChangeText={(text) => setProductDescription(text)}
          />
          <Text style={styles.whoPay}>{$t('commons.whoPay')}:</Text>
          <View style={styles.whoPayContent}>
            <View style={{ flex: 1 }}>
              <MainCheckBox
                round
                value={isPay}
                title={'Người gửi'}
                onPress={() => setIsPay(true)}
              />
            </View>
            <View style={{ flex: 1 }}>
              <MainCheckBox
                round
                value={!isPay}
                title={'Người nhận'}
                onPress={() => setIsPay(false)}
              />
            </View>
          </View>
        </InfoGroup>
        <InfoGroup
          textTitle="screens.createOrder.payCost"
          iconTitleName="ios-wallet"
        >
          <View style={styles.orderPrice}>
            <Text>{$t('screens.createOrder.totalPrice')}:</Text>
            <Text>{cost} VNĐ</Text>
          </View>
          <MainButton
            enable={canSubmit}
            onPress={handleConfirmOrder}
            text={$t('screens.createOrder.confirm')}
          />
        </InfoGroup>
      </ScrollView>
      <Overlay
        isVisible={showChosePlace}
        onBackdropPress={() => setShowChosePlace(false)}
      >
        <View style={styles.list}>
          {placeOfShipments.map((p, i) => (
            <TouchableOpacity
              style={styles.place}
              key={i}
              onPress={() => handleChosePlace(p)}
            >
              <Text>{`${_get(p, 'address', '')}, ${_get(
                p,
                'ward.name',
                ''
              )}, ${_get(p, 'ward.district.name', '')}, ${_get(
                p,
                'ward.district.province.name',
                ''
              )}`}</Text>
            </TouchableOpacity>
          ))}
        </View>
      </Overlay>
    </View>
  )
}

const mapState = (state) => ({ state })

export default connect(mapState, { setLoading })(CreateOrderScreen)

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: Colors.white,
  },
  titleContainer: {
    flexDirection: 'row',
    width: '100%',
    height: 40,
    marginBottom: 20,
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: Colors.primary,
    paddingHorizontal: '5%',
  },
  textTitle: {
    color: Colors.white,
  },
  iconTitleContainer: {
    marginRight: 10,
  },
  contentContainer: {
    paddingHorizontal: '5%',
  },
  whoPayContent: {
    alignItems: 'center',
    marginVertical: 10,
    flexDirection: 'row',
  },
  orderPrice: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  titleLeft: {
    flexDirection: 'row',
  },
  place: {
    height: 40,
    lineHeight: 40,
    borderBottomColor: Colors.primary,
    borderBottomWidth: 2,
    justifyContent: 'center',
  },
})

const InfoGroup = (props) => {
  const {
    textTitle,
    iconTitleName,
    iconTitleType,
    children,
    iconTitleSize,
    chosePlace,
    chosePlacePress,
    chosedPlace,
    createPlace,
  } = props
  return (
    <View style={styles.container}>
      <View style={styles.titleContainer}>
        <View style={styles.titleLeft}>
          <View style={styles.iconTitleContainer}>
            <Icon
              name={iconTitleName}
              color={Colors.white}
              type={iconTitleType || 'ionicon'}
              size={iconTitleSize || 20}
            />
          </View>
          <View style={styles.textTitleContainer}>
            <Text style={styles.textTitle}>{$t(textTitle)}</Text>
          </View>
        </View>
        {chosePlace && (
          <TouchableOpacity
            style={styles.titleRight}
            onPress={chosedPlace ? createPlace : chosePlacePress}
          >
            <Icon
              name={chosedPlace ? 'ios-add-circle-outline' : 'ios-card'}
              color={Colors.white}
              type={'ionicon'}
              size={iconTitleSize || 20}
            />
          </TouchableOpacity>
        )}
      </View>
      <View style={styles.contentContainer}>{children}</View>
    </View>
  )
}
