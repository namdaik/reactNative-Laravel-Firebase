import React from 'react'
import { NavigationContainer } from '@react-navigation/native'
import { createStackNavigator } from '@react-navigation/stack'
import {
  LoginScreen,
  RegisterScreen,
  SendOtpScreen,
  VerifyOtpScreen,
} from '../screens/auth'

const Auth = createStackNavigator()
const INITIAL_ROUTE_NAME = 'Login'

export default function AuthNavigator() {
  return (
    <NavigationContainer>
      <Auth.Navigator
        initialRouteName={INITIAL_ROUTE_NAME}
        screenOptions={{ header: () => null }}
      >
        <Auth.Screen name="Login" component={LoginScreen} />
        <Auth.Screen name="SendOtp" component={SendOtpScreen} />
        <Auth.Screen name="VerifyOtp" component={VerifyOtpScreen} />
        <Auth.Screen name="Register" component={RegisterScreen} />
      </Auth.Navigator>
    </NavigationContainer>
  )
}
