import Colors from '../../constants/colors'

export const cleanAccents = (str) => {
  str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a')
  str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e')
  str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i')
  str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o')
  str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u')
  str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y')
  str = str.replace(/đ/g, 'd')
  str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, 'A')
  str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, 'E')
  str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, 'I')
  str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, 'O')
  str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, 'U')
  str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, 'Y')
  str = str.replace(/Đ/g, 'D')
  // Combining Diacritical Marks
  str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, '') // huyền, sắc, hỏi, ngã, nặng
  str = str.replace(/\u02C6|\u0306|\u031B/g, '') // mũ â (ê), mũ ă, mũ ơ (ư)

  return str
}

export const toSortName = (name) => {
  const n = cleanAccents(name).match(/\b[\w]/g) || []
  return `${n.shift() || ''}${n.pop() || ''}`.toUpperCase()
}

export const statusToOrderIcon = (status) => {
  switch (Number(status)) {
    case 0:
      return { name: 'av-timer', color: Colors.primary }
    case 1:
      return { name: 'cloud-done', color: Colors.primary }
    case 2:
      return { name: 'local-shipping', color: Colors.primary }
    case 3:
      return { name: 'archive', color: Colors.primary }
    case 4:
      return { name: 'directions-run', color: Colors.primary }
    case 5:
      return { name: 'assignment-turned-in', color: Colors.primary }
    default:
      return { name: 'not-interested', color: Colors.danger }
  }
}

export const toOrderStatusKey = (status, prefix = 'commons.orderStatus') => {
  switch (Number(status)) {
    case 0:
      return `${prefix}.zero`
    case 1:
      return `${prefix}.one`
    case 2:
      return `${prefix}.two`
    case 3:
      return `${prefix}.three`
    case 4:
      return `${prefix}.four`
    case 5:
      return `${prefix}.five`
    default:
      return `${prefix}.negativeOne`
  }
}
