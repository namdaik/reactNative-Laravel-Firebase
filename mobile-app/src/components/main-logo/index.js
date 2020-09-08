import React, { useEffect, useState } from 'react'
import { Animated, StyleSheet } from 'react-native'
import { Avatar as Logo } from 'react-native-elements'
import Colors from '../../constants/colors'
import { toSortName } from '../../helpers/string'

const MainLogo = ({ isHidden, containerStyle, size, titleStyle }) => {
  const logoSize = 120
  const staticTitleStyle = { fontSize: logoSize / 3 }
  const [logoVisited] = useState(new Animated.Value(1))
  useEffect(() => {
    setHiddenLogo(isHidden)
  }, [isHidden])

  const setHiddenLogo = (isHidden) => {
    Animated.timing(logoVisited, {
      toValue: isHidden ? 0 : 1,
      duration: 500,
    }).start()
  }

  return (
    <Animated.View
      style={[styles.logoContainer, { opacity: logoVisited }, containerStyle]}
    >
      <Logo
        rounded
        source={APP_LOGO}
        size={size || logoSize}
        title={toSortName(APP_NAME)}
        titleStyle={titleStyle || staticTitleStyle}
        containerStyle={styles.logo}
      />
    </Animated.View>
  )
}
export default MainLogo
const styles = StyleSheet.create({
  logoContainer: {
    alignItems: 'center',
    justifyContent: 'center',
  },
  logo: {
    borderWidth: 5,
    borderColor: Colors.primary,
  },
})
