import I18n from 'i18n-js'
class ErrorShippingCost {
  constructor(i18nKey, defaultMessage, params) {
    this.key = i18nKey
    this.message = I18n.t(`validation.${i18nKey}`, { defaultValue: defaultMessage, ...params })
  }
}
/**
 * @param sendFrom Bao gồm vùng miền và tỉnh thành
 * @param sendTo Bao gồm vùng miền và tỉnh thành
 * @param orderProps Các thuộc của tính gói hàng
 * @note sendForm và sendTo cần có cùng kiểu dữ liệu để đưa ra kết quả chính xác nhất
 */
export default class HandleShippingCost {
  constructor(sendFrom, sendTo, orderProps) {
    this.distance = new CheckDistance(sendFrom, sendTo)
    this.order = new Order(orderProps)
    if (this.order.weight > this.distance.maxWeight) {
      throw new ErrorShippingCost('maxWeightOrder', `Trọng lượng gói hàng không được vượt quá ${this.distance.maxWeight / 1000} (Kg)`, {max: this.distance.maxWeight / 1000})
    }
    if (this.order.length > this.distance.maxSize || this.order.width > this.distance.maxSize || this.order.height > this.distance.maxSize) {
      throw new ErrorShippingCost('maxSizeOrder', `Kích thước mỗi chiều không vượt quá ${this.distance.maxSize} (cm)`, {max: this.distance.maxSize})
    }
    this.estimate = this.distance.basePrice + (this.distance.stepPrice * Math.max(0, Math.ceil((this.order.conversionVolume - this.distance.baseWeight) / 500)))
  }
}

class AddressProps {
  constructor(props) {
    if (props.province) {
      this.province = props.province.toString().toUpperCase()
    } else if (props.name) {
      this.province = props.name.toString().toUpperCase()
    } else {
      throw 'missingProvince'
    }
    if (props.region) {
      this.region = props.region.toString().toUpperCase()
    } else if (props.region_name) {
      this.region = props.region_name.toString().toUpperCase()
    } else {
      throw 'missingRegion'
    }
  }
}

/**
 * @param weight (g) Cân nặng của gói hàng
 * @param length (cm) Chiều dài của gói hàng
 * @param width (cm) Chiều rộng của gói hàng
 * @param height (cm) Chiều cao của gói hàng
 * @var conversionVolume (cm) = Math.max(weight,((length * width * height) / 5))
 */
class Order {
  constructor(props) {
    const { weight, length, width, height } = props
    this.weight = weight
    this.length = length
    this.width = width
    this.height = height
    this.conversionVolume = Math.max(weight, ((length * width * height) / 5))
    if (this.conversionVolume <= 0) {
      throw new ErrorShippingCost('missingOrderProps', `Vui lòng điền khối lượng hoặc đầy đủ kích thước dài X rộng X cao`)
    }
  }
}

class CheckDistance {
  maxWeight = 20000
  maxSize = 80
  constructor(sendFrom, sendTo) {
    try {
      this.from = new AddressProps(sendFrom)
    } catch (error) {
      throw new ErrorShippingCost('missingSendFrom', 'Vui lòng trọn địa chỉ gửi hàng')
    }
    try {
      this.to = new AddressProps(sendTo)
    } catch (error) {
      throw new ErrorShippingCost('missingSendTo', 'Vui lòng trọn địa chỉ nhận hàng')
    }
    if (this.from.province === this.to.province) {
      this.level = 1
      this.basePrice = 16000
      this.baseWeight = 2000
      this.stepPrice = 2500
      this.maxWeight = 20000
    } else {
      if (this.from.region === this.to.region) {
        this.level = 2
        this.basePrice = 30000
        this.baseWeight = 500
        this.stepPrice = 5000
        this.maxWeight = 10000
      } else {
        if ((Math.abs(Number(this.from.region) - Number(this.to.region)) < 2) || (this.from.region === "MIỀN TRUNG") || (this.to.region === "MIỀN TRUNG")) {
          this.level = 3
          this.basePrice = 35000
          this.baseWeight = 500
          this.stepPrice = 10000
          this.maxWeight = 6000
        } else {
          this.level = 4
          this.basePrice = 45000
          this.baseWeight = 500
          this.stepPrice = 15000
          this.maxWeight = 6000
        }
      }
    }
  }
}
