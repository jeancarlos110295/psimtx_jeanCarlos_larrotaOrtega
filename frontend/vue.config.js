module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],

  devServer: {
    port: 8080,
    https: false,
    public: 'http://localhost:8080',
    watchOptions: {
      poll: false
    }
  },
  
  runtimeCompiler: true
}