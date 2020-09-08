import { showMessage } from 'react-native-flash-message'

export const setAuth = (data) => ({ type: 'SET_AUTH', ...data })
export const setCurentUser = (data) => ({ type: 'SET_USER', ...data })
export const setNotifyList = (notify) => ({ type: 'SET_NOTIFY_LIST', notify })
export const setLoading = (loading) => ({ type: 'SET_LOADING', loading })
export const setWakeup = (wakeup) => ({ type: 'SET_WAKEUP', wakeup })
export const setAppLocale = (locale) => ({ type: 'SET_LOCALE', locale })
export const showDevModel = () => {
  showMessage({
    message: 'Chức năng đang được phát triển!',
    description: 'Rất xin lỗi vì sự bất tiện này...',
    duration: 2500,
    type: 'warning',
  })
}
