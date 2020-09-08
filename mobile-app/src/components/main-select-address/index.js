import React, { useState, useEffect } from 'react'
import { StyleSheet, View, Text, Picker } from 'react-native'
import Colors from '../../constants/colors'
import Data from '../../helpers/data'
import { Icon } from 'react-native-elements'
const MainSelectAddress = ({
  selectedProvince,
  selectedDistrict,
  selectedWard,
  eachGroupStyle,
  sender,
}) => {
  const [province, setProvince] = useState({})
  const [districts, setDistricts] = useState([])
  const [district, setDistrict] = useState({})
  const [wards, setWards] = useState([])
  const [ward, setWard] = useState({})
  useEffect(() => {
    handleSelectProvince(Data.provinces[0])
  }, [])
  const handleSelectProvince = (item) => {
    setProvince(item)
    setDistricts(item.districts)
    handleSelectDistrict(item.districts[0])
    if (selectedProvince) {
      selectedProvince(item)
    }
  }
  const handleSelectDistrict = (item) => {
    setDistrict(item)
    setWards(item.wards)
    handleSelectWard(item.wards[0])
    if (selectedDistrict) {
      selectedDistrict(item)
    }
  }
  const handleSelectWard = (item) => {
    setWard(item)
    if (selectedWard) {
      selectedWard(item)
    }
  }
  return (
    <View>
      <View style={{ paddingBottom: 6 }}>
        <View style={[styles.inputGroup, eachGroupStyle]}>
          <View style={styles.iconBlock}>
            <Icon
              name={sender ? 'ios-log-in' : 'ios-log-out'}
              type="ionicon"
              size={25}
              color={Colors.secondary}
            />
          </View>
          <Picker
            name="SelectProvince"
            style={styles.input}
            selectedValue={province}
            onValueChange={(item) => handleSelectProvince(item)}
          >
            {Data.provinces.map((item, index) => (
              <Picker.Item key={index} label={item.name} value={item} />
            ))}
          </Picker>
        </View>
      </View>
      <View style={{ paddingBottom: 6 }}>
        <View style={[styles.inputGroup, eachGroupStyle]}>
          <View style={styles.iconBlock}>
            <Icon
              name={sender ? 'ios-log-in' : 'ios-log-out'}
              type="ionicon"
              size={25}
              color={Colors.secondary}
            />
          </View>
          <Picker
            name="SelectDistrict"
            style={styles.input}
            selectedValue={district}
            onValueChange={(item) => handleSelectDistrict(item)}
          >
            {districts.map((item, index) => (
              <Picker.Item key={index} label={item.name} value={item} />
            ))}
          </Picker>
        </View>
      </View>
      <View style={{ paddingBottom: 6 }}>
        <View style={[styles.inputGroup, eachGroupStyle]}>
          <View style={styles.iconBlock}>
            <Icon
              name={sender ? 'ios-log-in' : 'ios-log-out'}
              type="ionicon"
              size={25}
              color={Colors.secondary}
            />
          </View>
          <Picker
            name="SelectWard"
            style={styles.input}
            selectedValue={ward}
            onValueChange={(item) => handleSelectWard(item)}
          >
            {wards.map((item, index) => (
              <Picker.Item key={index} label={item.name} value={item} />
            ))}
          </Picker>
        </View>
      </View>
    </View>
  )
}

export default MainSelectAddress

const styles = StyleSheet.create({
  errorInput: {
    color: Colors.danger,
    fontSize: 12,
    fontStyle: 'italic',
  },
  inputGroup: {
    width: '100%',
    backgroundColor: Colors.inputBackground,
    borderRadius: 10,
    flexDirection: 'row',
    marginBottom: 2,
  },
  input: {
    padding: 0,
    flex: 0.85,
    height: 50,
  },
  iconBlock: {
    flex: 0.15,
    justifyContent: 'center',
    alignItems: 'center',
  },
})
