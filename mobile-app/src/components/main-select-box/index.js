import React, { useState } from 'react'
import { StyleSheet, View, Text, Picker } from 'react-native'
import { Ionicons as Icon } from '@expo/vector-icons'
import Colors from '../../constants/colors'

const MainSelectBox = (props) => {
  const [error] = useState('')
  return (
    <View style={{ paddingBottom: 6 }}>
      <View style={[styles.inputGroup, props.style]}>
        <View style={styles.iconBlock}>
          <Icon
            name={props.iconName || 'ios-home'}
            size={props.iconSize || 25}
            color={Colors.secondary}
          />
        </View>
        <Picker
          itemStyle={{
            backgroundColor: 'red',
            borderColor: 'red',
            borderWidth: 8,
          }}
          mode={props.mode}
          style={styles.input}
          selectedValue={props.selectedValue}
          onValueChange={props.onValueChange}
        >
          {props.items.map((item, index) => (
            <Picker.Item
              style={{ backgroundColor: 'red' }}
              disabled={true}
              key={index}
              label={item.label || 'option' + index + 1}
              value={item.value}
            />
          ))}
        </Picker>
      </View>
      <View>
        <Text style={styles.errorInput}>{error}</Text>
      </View>
    </View>
  )
}

export default MainSelectBox

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
