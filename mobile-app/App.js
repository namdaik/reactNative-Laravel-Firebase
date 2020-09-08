import React from 'react'
import { Provider } from 'react-redux'
import store from './src/store'
import axios from 'axios'
import './src/lang'
import FlastMessage from 'react-native-flash-message'
import RootScreen from './src/screens/RootScreen'
import { LoadingOverlay } from './src/components'

// define global axios
window.axios = axios
window.axios.defaults.headers.common['Content-Type'] = 'application/json'
window.axios.defaults.headers.common['Accept'] = 'application/json'
window.axios.defaults.baseURL = 'https://quickorder2020.tk/api'
window.APP_NAME = 'Quick Order'
window.APP_LOGO = require('./src/assets/images/logo.png')

export default class App extends React.Component {
  render() {
    return (
      <Provider store={store}>
        <LoadingOverlay />
        <RootScreen />
        <FlastMessage position="top" />
      </Provider>
    )
  }
}
