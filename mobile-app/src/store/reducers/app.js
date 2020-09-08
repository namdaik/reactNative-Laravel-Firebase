const initialState = {
  wakeup: false,
  loading: false,
  locale: null,
}

const app = (state = initialState, action) => {
  const { type, wakeup, loading, locale } = action
  switch (type) {
    case 'SET_WAKEUP':
      return { ...state, wakeup }

    case 'SET_LOADING':
      return { ...state, loading }

    case 'SET_LOCALE':
      setAppLocale(action.locale)
      return { ...state, locale }

    default:
      return state
  }
}

export default app
