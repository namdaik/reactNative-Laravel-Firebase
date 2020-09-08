import React from 'react'
import { StyleSheet, View, Text, TouchableOpacity } from 'react-native'
import Colors from '../../constants/colors'

const MainButton = ({ disable, enable, onPress, text }) => {
  if (disable || !enable) {
    return (
      <View style={styles.disable}>
        <Text style={styles.textPrimary}>{text}</Text>
      </View>
    )
  }

  return (
    <TouchableOpacity style={styles.enable} onPress={onPress}>
      <Text style={styles.textWhite}>{text}</Text>
    </TouchableOpacity>
  )
}

export default MainButton

const styles = StyleSheet.create({
  textPrimary: {
    color: Colors.primary,
  },
  textWhite: {
    color: Colors.white,
  },
  disable: {
    justifyContent: 'center',
    alignItems: 'center',
    height: 50,
    width: '100%',
    borderRadius: 10,
    marginVertical: 20,
    borderColor: Colors.primary,
    borderWidth: 1,
  },
  enable: {
    justifyContent: 'center',
    alignItems: 'center',
    height: 50,
    width: '100%',
    borderRadius: 10,
    marginVertical: 20,
    backgroundColor: Colors.primary,
  },
})
