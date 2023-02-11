const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  indexPath: process.env.NODE_ENV === 'production'
      ? '../../content/themes/default/app.php'
      : 'index.html'
})
