export const hasValue = (value) => {
  if (value || value.trim() != '') {
    return true
  }
  return false
}
export const isEmail = (value) => {
  return RegExp(
    '^[a-zA-Z]+([a-zA-Z0-9]?(\\.|_)?){1,4}[a-zA-Z0-9]+@[a-zA-Z]{2,}(\\.[a-zA-Z]{2,5}){1,3}$'
  ).test(value)
}

String.prototype.customTrim = function (char) {
  return this.customLeftTrim(char).customRightTrim(char)
}
String.prototype.customLeftTrim = function (char) {
  let strSplit = this.split(char)
  let trimCount = 0
  for (let i = 0; i < strSplit.length; i++) {
    if (strSplit[i] !== '') {
      break
    }
    trimCount++
  }
  strSplit.splice(0, trimCount)
  return strSplit.join(char)
}
String.prototype.customRightTrim = function (char) {
  char = char.split('').reverse().join('')
  let strSplit = this.split('').reverse().join('').split(char)
  let trimCount = 0
  for (let i = 0; i < strSplit.length; i++) {
    if (strSplit[i] !== '') {
      break
    }
    trimCount++
  }
  strSplit.splice(0, trimCount)
  return strSplit.join(char).split('').reverse().join('')
}
