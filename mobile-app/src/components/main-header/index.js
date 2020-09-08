import React from 'react'
import { StyleSheet } from 'react-native'
import { Header } from 'react-native-elements'
import Colors from '../../constants/colors'

const MainHeader = ({
  title,
  titleStyle,
  goBack,
  rightComponent,
  leftComponent,
  backgroundColor,
}) => {
  return (
    <Header
      leftComponent={
        goBack
          ? {
              icon: 'keyboard-arrow-left',
              size: 25,
              color: Colors.primary,
              onPress: goBack,
            }
          : leftComponent
      }
      centerComponent={{
        text: title,
        style: titleStyle || styles.title,
      }}
      rightComponent={rightComponent || null}
      backgroundColor={backgroundColor || Colors.white}
    />
  )
}

const styles = StyleSheet.create({
  title: {
    color: Colors.primary,
    fontWeight: 'bold',
    fontSize: 16,
  },
})

export default MainHeader
