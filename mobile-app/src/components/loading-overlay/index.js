import React from 'react'
import Spinner from 'react-native-loading-spinner-overlay'
import Colors from '../../constants/colors'
import { connect } from 'react-redux'

const LoadingOverlay = ({ state }) => {
  return <Spinner visible={state.app.loading} color={Colors.primary} overlayColor={Colors.overlay} />
}

const mapState = (state) => ({ state })

export default connect(mapState, null)(LoadingOverlay)
