import React from 'react'
import { View } from 'react-native'
import { Overlay } from 'react-native-elements'
import Colors from '../../constants/colors'
import QRCode from 'react-native-qrcode-svg'
const MainQRCode = ({ code, isShow, onBackdropPress }) => {
  return (
    <Overlay
      isVisible={isShow}
      onBackdropPress={onBackdropPress}
      width={320}
      height={320}
    >
      <View>
        <QRCode
          value={code}
          size={300}
          backgroundColor={Colors.white}
          color={Colors.black}
          logoBorderRadius={75}
          logo={APP_LOGO}
        />
      </View>
    </Overlay>
  )
}
export default MainQRCode
