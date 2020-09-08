if (['admin', 'client'].includes(process.env.npm_config_section)) {
  require(`${__dirname}/webpack.${process.env.npm_config_section}.mix.js`)
} else {
  console.log(
    '\x1b[41m%s\x1b[0m',
    'Provide correct --section argument to build command: admin, client'
  )
  throw new Error('Provide correct --section argument to build command!')
}
