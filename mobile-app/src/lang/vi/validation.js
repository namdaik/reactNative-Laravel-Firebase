export default {
  /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
  missingOrderProps: 'Vui lòng điền khối lượng hoặc đầy đủ kích thước dài X rộng X cao',
  maxWeightOrder: 'Trọng lượng gói hàng không được vượt quá {{max}} (Kg)',
  maxSizeOrder: 'Kích thước mỗi chiều không vượt quá {{max}} (cm)',
  missingSendFrom: 'Vui lòng trọn địa chỉ gửi hàng',
  missingSendTo: 'Vui lòng trọn địa chỉ nhận hàng',
  accepted: 'The {{attribute}} must be accepted.',
  active_url: 'The {{attribute}} is not a valid URL.',
  after: '{{attribute}} phải là một ngày sau {{date}}.',
  after_or_equal: '{{attribute}} phải là một ngày từ {{date}} trở đi.',
  alpha: 'The {{attribute}} may only contain letters.',
  alpha_dash:
    'The {{attribute}} may only contain letters, numbers, dashes and underscores.',
  alpha_num: 'The {{attribute}} may only contain letters and numbers.',
  array: '{{attribute}} phải là một mảng.',
  before: '{{attribute}} phải là một ngày trước {{date}}.',
  before_or_equal: '{{attribute}} phải là một ngày từ {{date}} trở về.',
  between: {
    numeric: '{{attribute}} phải nằm trong khoảng {{min}} đến {{max}}.',
    file: '{{attribute}} phải nằm trong khoảng {{min}} đến {{max}} kilobytes.',
    string: '{{attribute}} phải nằm trong khoảng {{min}} đến {{max}} ký tự.',
    array:
      'The {{attribute}} phải nằm trong khoảng {{min}} đến {{max}} phần tử.',
  },
  boolean: '{{attribute}} phải là giá trị đúng hoặc sai.',
  confirmed: 'The {{attribute}} confirmation does not match.',
  date: '{{attribute}} không phải một ngày hợp lệ.',
  date_equals: 'The {{attribute}} must be a date equal to {{date}}.',
  date_format: '{{attribute}} phải đúng định dạng {{format}}.',
  different: 'The {{attribute}} and {{other}} must be different.',
  digits: 'The {{attribute}} must be {{digits}} digits.',
  digits_between:
    'The {{attribute}} must be between {{min}} and {{max}} digits.',
  dimensions: 'The {{attribute}} has invalid image dimensions.',
  distinct: 'The {{attribute}} field has a duplicate value.',
  email: '{{attribute}} phải đúng định dạng email.',
  ends_with:
    'The {{attribute}} must end with one of the following: {{values}}.',
  exists: '{{attribute}} không hợp lệ.',
  file: '{{attribute}} phải là một tệp.',
  filled: '{{attribute}} phải có giá trị.',
  gt: {
    numeric: 'The {{attribute}} must be greater than {{value}}.',
    file: 'The {{attribute}} must be greater than {{value}} kilobytes.',
    string: 'The {{attribute}} must be greater than {{value}} characters.',
    array: 'The {{attribute}} must have more than {{value}} items.',
  },
  gte: {
    numeric: 'The {{attribute}} must be greater than or equal {{value}}.',
    file:
      'The {{attribute}} must be greater than or equal {{value}} kilobytes.',
    string:
      'The {{attribute}} must be greater than or equal {{value}} characters.',
    array: 'The {{attribute}} must have {{value}} items or more.',
  },
  image: '{{attribute}} phải là một ảnh.',
  in: 'The selected {{attribute}} is invalid.',
  in_array: 'The {{attribute}} field does not exist in {{other}}.',
  integer: '{{attribute}} phải là một số nguyên.',
  ip: '{{attribute}} phải là một địa chỉ IP.',
  ipv4: '{{attribute}} phải là một địa chỉ IP4.',
  ipv6: '{{attribute}} phải là một địa chỉ IP6.',
  json: '{{attribute}} phải là một chuỗi json.',
  lt: {
    numeric: 'The {{attribute}} must be less than {{value}}.',
    file: 'The {{attribute}} must be less than {{value}} kilobytes.',
    string: 'The {{attribute}} must be less than {{value}} characters.',
    array: 'The {{attribute}} must have less than {{value}} items.',
  },
  lte: {
    numeric: 'The {{attribute}} must be less than or equal {{value}}.',
    file: 'The {{attribute}} must be less than or equal {{value}} kilobytes.',
    string:
      'The {{attribute}} must be less than or equal {{value}} characters.',
    array: 'The {{attribute}} must not have more than {{value}} items.',
  },
  max: {
    numeric: '{{attribute}} không được lớn hơn {{max}}.',
    file: '{{attribute}} không được lớn hơn {{max}} kilobytes.',
    string: '{{attribute}} không được lớn hơn {{max}} ký tự.',
    array: '{{attribute}} không được lớn hơn {{max}} phần tử.',
  },
  mimes: '{{attribute}} phải là một file có dạng: {{values}}.',
  mimetypes: '{{attribute}} phải là một file có dạng: {{values}}.',
  min: {
    numeric: '{{attribute}} phải lớn hơn hoặc bằng {{min}}.',
    file: '{{attribute}} phải lớn hơn hoặc bằng {{min}} kilobytes.',
    string: '{{attribute}} phải có ít nhất {{min}} ký tự.',
    array: '{{attribute}} phải có ít nhất {{min}} phần tử.',
  },
  not_in: 'The selected {{attribute}} is invalid.',
  not_regex: 'The {{attribute}} format is invalid.',
  numeric: '{{attribute}} phải là một số.',
  password: 'The password is incorrect.',
  present: 'The {{attribute}} field must be present.',
  regex: '{{attribute}} không đúng định dạng.',
  required: '{{attribute}} không được để trống.',
  required_if:
    'The {{attribute}} field is required when {{other}} is {{value}}.',
  required_unless:
    'The {{attribute}} field is required unless {{other}} is in {{values}}.',
  required_with:
    'The {{attribute}} field is required when {{values}} is present.',
  required_with_all:
    'The {{attribute}} field is required when {{values}} are present.',
  required_without:
    'The {{attribute}} field is required when {{values}} is not present.',
  required_without_all:
    'The {{attribute}} field is required when none of {{values}} are present.',
  same: '{{attribute}} phải khớp với với {{other}}',
  size: {
    numeric: '{{attribute}} phải có kích cỡ {{size}}.',
    file: '{{attribute}} phải có kích cỡ {{size}} kilobytes.',
    string: '{{attribute}} phải có {{size}} ký tự.',
    array: '{{attribute}} phải có {{size}} phần tử.',
  },
  starts_with: '{{attribute}} phải được bắt đầu bằng: {{values}}.',
  string: '{{attribute}} phải là một chuỗi.',
  timezone: 'The {{attribute}} must be a valid zone.',
  unique: '{{attribute}} đã tồn tại.',
  uploaded: 'The {{attribute}} failed to upload.',
  url: 'The {{attribute}} format is invalid.',
  uuid: 'The {{attribute}} must be a valid UUID.',

  /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

  custom: {
    'attribute-name': {
      'rule-name': 'custom-message',
    },
  },

  /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

  attributes: {
    name: 'Tên',
    email: 'Email',
    note: 'Ghi chú',
    fullName: 'Họ và tên',
    phone: 'Số điện thoại',
    password: 'Mật khẩu',
    address: 'Địa chỉ',
    weight: 'Cân nặng',
    width: 'Chiều dài',
    length: 'Chiều dài',
    height: 'Chiều cao',
    whoPay: 'Người thanh toán',
    addressDetail: 'Địa chỉ chi tiết',
    passwordConfirm: 'Xác nhận mật khẩu'
  },
}
