import * as React from 'react'
import { NavigationContainer } from '@react-navigation/native'
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs'
import { createStackNavigator } from '@react-navigation/stack'
import { MainTabBarIcon } from '../components'
import { ShowProfileScreen, EditProfileScreen } from '../screens/app/profiles'
import {
  CreateOrderScreen,
  ShowOrderScreen,
  OrderListsScreen,
  ListDetailScreen,
} from '../screens/app/orders'
import { HomeScreen, NotifyScreen, ScanCodeScreen } from '../screens/app/homes'



const AppTab = createBottomTabNavigator()
const AppStack = createStackNavigator()
const INITIAL_ROUTE_NAME = 'Home'
const AppNavigator = () => {
  return (
    <NavigationContainer>
      <AppStack.Navigator screenOptions={{ header: () => null }}>
        <AppStack.Screen name="TabBar" component={AppTabNavigator} />
        <AppStack.Screen name="ScanCode" component={ScanCodeScreen} />
        <AppStack.Screen name="ShowOrder" component={ShowOrderScreen} />
        <AppStack.Screen name="EditProfile" component={EditProfileScreen} />
        <AppStack.Screen name="ListDetail" component={ListDetailScreen} />
      </AppStack.Navigator>
    </NavigationContainer>
  )
}

const AppTabNavigator = () => {
  return (
    <AppTab.Navigator
      initialRouteName={INITIAL_ROUTE_NAME}
      tabBarOptions={{ showLabel: false }}
    >
      <AppTab.Screen
        name="Home"
        component={HomeScreen}
        options={{
          tabBarIcon: ({ focused }) => (
            <MainTabBarIcon focused={focused} name="ios-home" />
          ),
        }}
      />
      <AppTab.Screen
        name="ListOrder"
        component={OrderListsScreen}
        options={{
          tabBarIcon: ({ focused }) => (
            <MainTabBarIcon focused={focused} name="ios-cube" />
          ),
        }}
      />
      <AppTab.Screen
        name="CreateOrder"
        component={CreateOrderScreen}
        options={{
          tabBarVisible: false,
          tabBarIcon: ({ focused }) => (
            <MainTabBarIcon big focused={focused} name="ios-add-circle" />
          ),
        }}
      />
      <AppTab.Screen
        name="Notification"
        component={NotifyScreen}
        options={{
          tabBarIcon: ({ focused }) => (
            <MainTabBarIcon focused={focused} name="ios-notifications" />
          ),
        }}
      />
      <AppTab.Screen
        name="Profile"
        component={ShowProfileScreen}
        options={{
          tabBarVisible: false,
          tabBarIcon: ({ focused }) => (
            <MainTabBarIcon focused={focused} name="ios-person" />
          ),
        }}
      />
    </AppTab.Navigator>
  )
}

export default AppNavigator
