import React from 'react'
import {
  StyleSheet,
  View,
  TextInput,
  Text,
  TouchableOpacity,
} from 'react-native'
import { Ionicons as Icon } from '@expo/vector-icons'
import Colors from '../../constants/colors'
import Validator from '../../helpers/validator'

const MainGroupInput = (props) => {
  const [isSecure, setSecure] = React.useState(true)
  const [error, setError] = React.useState('')
  const [inputHeight, setInputHeight] = React.useState(50)
  const changeText = (text) => {
    props.onChangeText(text)
    if (props.rules) {
      let message = new Validator(
        props.rules,
        props.name,
        text,
        props.dataType || ''
      ).getMassage()
      setError(message)
      if (props.hasError) {
        props.hasError(message)
      }
    }
  }
  return (
    <View style={{ marginVertical: props.mVertical || 0, paddingBottom: 5 }}>
      <View style={[styles.inputGroup, props.style]}>
        <View style={styles.iconBlock}>
          <Icon
            name={props.iconName || 'ios-home'}
            type={props.iconType || 'ionicon'}
            size={props.iconSize || 25}
            color={Colors.secondary}
          />
        </View>
        <TextInput
          multiline={props.resizeable}
          onContentSizeChange={({ nativeEvent }) => {
            if (props.resizeable) {
              let contentSize = nativeEvent.contentSize.height
              setInputHeight(Math.max(50, contentSize))
            }
          }}
          textContentType={props.textContentType}
          onFocus={props.onFocus}
          onBlur={props.onBlur}
          style={[styles.input, { height: inputHeight }]}
          selectionColor={Colors.primary}
          placeholder={props.placeholder}
          onChangeText={changeText}
          editable={props.editable}
          value={props.value}
          secureTextEntry={props.securable ? isSecure : false}
          keyboardType={props.type}
        />
        {props.securable && !props.hiddenEye ? (
          <View style={styles.iconBlock}>
            {!props.value || (
              <TouchableOpacity onPress={() => setSecure(!isSecure)}>
                {isSecure ? (
                  <Icon name="ios-eye-off" size={22} color={Colors.secondary} />
                ) : (
                  <Icon name="ios-eye" size={22} color={Colors.secondary} />
                )}
              </TouchableOpacity>
            )}
          </View>
        ) : (
          <View></View>
        )}
      </View>
      <View>
        <Text style={styles.errorInput}>{props.error || error}</Text>
      </View>
    </View>
  )
}

export default MainGroupInput

const styles = StyleSheet.create({
  errorInput: {
    color: Colors.danger,
    fontSize: 11,
    fontStyle: 'italic',
  },
  inputGroup: {
    width: '100%',
    backgroundColor: Colors.inputBackground,
    borderRadius: 10,
    flexDirection: 'row',
  },
  input: {
    flex: 0.7,
  },
  iconBlock: {
    flex: 0.15,
    justifyContent: 'center',
    alignItems: 'center',
  },
})
