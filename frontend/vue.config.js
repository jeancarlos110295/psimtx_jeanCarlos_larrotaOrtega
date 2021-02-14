module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],

  devServer: {
    disableHostCheck: true,
    watchOptions: {
      poll: false
    },
    Host: 'localhost'
  },
  
  runtimeCompiler: true
}