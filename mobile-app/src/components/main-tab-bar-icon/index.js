import * as React from 'react'
import { Ionicons } from '@expo/vector-icons'
import Colors from '../../constants/colors'

export default function TabBarIcon(props) {
  return (
    <Ionicons
      name={props.name}
      size={props.big ? 60 : 25}
      style={{ marginBottom: -3, marginTop: props.big ? -25 : 0 }}
      color={props.focused ? Colors.primary : Colors.secondary}
    />
  )
}
