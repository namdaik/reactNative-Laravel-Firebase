import React from 'react'
import { StyleSheet, Text, TouchableOpacity } from 'react-native'
import Colors from '../../constants/colors'
import { Icon } from 'react-native-elements'

const MainCheckBox = ({ value, title, onPress, round, iconType }) => {
  const type = round ? 'checkmark-circle' : 'checkbox'
  return (
    <TouchableOpacity style={styles.container} onPress={onPress}>
      <Icon
        name={value ? `ios-${type}` : `ios-${type}-outline`}
        size={25}
        color={Colors.primary}
        type={iconType || 'ionicon'}
      />
      <Text> {title}</Text>
    </TouchableOpacity>
  )
}

export default MainCheckBox

const styles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    alignItems: 'center',
  },
})
