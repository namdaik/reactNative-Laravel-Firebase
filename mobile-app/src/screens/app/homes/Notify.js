import * as React from 'react'
import { StyleSheet, Text, View, ScrollView, ToastAndroid, TouchableOpacity } from 'react-native'
import { Icon } from 'react-native-elements'

export default function LinksScreen() {
  return (
    <ScrollView
      style={styles.container}
      contentContainerStyle={styles.contentContainer}
    >
      <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng ALDFJI đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng SDFLJI đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng SDFISS đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng IISLSF đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng LJOILS đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng IXLFIL đã cập nhật"
      />
       <OptionNotify
        icon="ios-notifications"
        label="Đơn hàng OADSKL đã cập nhật"
      />
    </ScrollView>
  )
}

function OptionNotify({ icon, label, onPress, isLastOption }) {
  return (
    <TouchableOpacity
      style={[styles.option, isLastOption && styles.lastOption]}
      onPress={() => ToastAndroid.showWithGravity(
        $t('commons.wip'),
        ToastAndroid.SHORT,
        ToastAndroid.CENTER
      )}
    >
      <View style={{ flexDirection: 'row' }}>
        <View style={styles.optionIconContainer}>
          <Icon type="ionicon" name={icon} size={22} color="rgba(0,0,0,0.35)" />
        </View>
        <View style={styles.optionTextContainer}>
          <Text style={styles.optionText}>{label}</Text>
        </View>
      </View>
    </TouchableOpacity>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fafafa',
  },
  contentContainer: {
    paddingTop: 15,
  },
  optionIconContainer: {
    marginRight: 12,
  },
  option: {
    backgroundColor: '#fdfdfd',
    paddingHorizontal: 15,
    paddingVertical: 15,
    borderWidth: StyleSheet.hairlineWidth,
    borderBottomWidth: 0,
    borderColor: '#ededed',
  },
  lastOption: {
    borderBottomWidth: StyleSheet.hairlineWidth,
  },
  optionText: {
    fontSize: 15,
    alignSelf: 'flex-start',
    marginTop: 1,
  },
})
