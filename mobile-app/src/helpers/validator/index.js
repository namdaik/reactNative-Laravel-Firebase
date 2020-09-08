import I18n from 'i18n-js'
import { hasValue, isEmail } from './check'
export default class Validator {
  constructor(rules, attribute, value, dataType = '', sameData = null) {
    if (this.sameData) {
      this.sameData = {
        value: sameData.value,
        attribute: this.transAttribute(sameData.attribute),
      }
    }
    this.dataType = dataType
    this.value = value
    this.messages = []
    this.rule = {}
    this.rules = this.passerRules(rules)
    this.attribute = this.transAttribute(attribute)
    this.validate()
  }

  validate = () => {
    this.rules.forEach((rule) => {
      rule = this.passerRule(rule)
      if (rule.name === 'required' && !hasValue(this.value)) {
        this.addError(rule)
        return
      }

      if (rule.name === 'email' && !isEmail(this.value)) {
        this.addError(rule)
        return
      }

      if (rule.name === 'numeric' && !Number(this.value)) {
        this.addError(rule)
        return
      }
      if (rule.name === 'max' && Number(this.value) > Number(rule.params.max)) {
        this.addError({ ...rule, type: true })
        return
      }
    })
  }

  addError = (rule) => {
    const dataType = rule.type ? `.${this.dataType}` : ''
    this.messages.push(
      I18n.t(`validation.${rule.name}${dataType}`, {
        ...rule.params,
        defaultValue: `The ${rule.params.attribute} is not pass '${rule.name}' rule`,
      })
    )
  }

  transAttribute = (attribute) => {
    return I18n.t(`validation.attributes.${attribute}`, {
      defaultValue: attribute,
    })
  }

  passerRules = (rules) => {
    var result = []
    if (typeof rules === 'string') {
      rules = rules.split('|')
    }
    rules.forEach((rule) => {
      let [name, params] = rule.split(':')
      params = params ? params.split(',') : []
      result.push({ name, params })
    })
    return result
  }

  passerRule = (rule) => {
    var params = {
      attribute: this.attribute,
    }
    var ruleNameLikeParamName = ['min', 'max', 'size'].includes(rule.name)
    if (ruleNameLikeParamName) {
      params[rule.name] = rule.params[0]
    } else if (rule.name === 'between') {
      params.min = rule.params[0]
      params.max = rule.params[1]
    } else if (rule.name === 'after' || rule.name === 'before') {
      params.date = rule.params[0]
    }
    return {name: rule.name, params}
  }

  getMassage = () => this.messages[0] || null
  getMassages = () => this.messages || []
}
