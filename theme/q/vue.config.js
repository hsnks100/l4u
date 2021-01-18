module.exports = {
  devServer: {
    port: 8080, // CHANGE YOUR PORT HERE!
    proxy: {
      "/api": {
        target: "http://localhost/g5/api",
        changeOrigin: true,
        pathRewrite: {
          "^/api": "",
        },
      },
    },
  },
  runtimeCompiler: true,
  outputDir: "./dist",
};
