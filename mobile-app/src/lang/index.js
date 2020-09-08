import { AsyncStorage } from 'react-native'
import * as Localization from 'expo-localization'
import i18n from 'i18n-js'
import vi from './vi'
import en from './en'
;(async () => {
  let appLocale = await AsyncStorage.getItem('@App:locale')
  i18n.locale = appLocale || Localization.locale
})()
i18n.fallbacks = true
i18n.translations = {
  en,
  vi,
}
window.setAppLocale = async (locale) => {
  i18n.locale = locale
  await AsyncStorage.setItem('@App:locale', locale)
}
window.$t = (key, params = {}) => i18n.t(key, { ...params })
