const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
  entry: path.resolve(__dirname, "src/app.js"),
  mode: "development",
  devtool: "eval-cheap-module-source-map",
  devServer: {
    hot: true,
    headers: {
      "Access-Control-Allow-Origin": "*",
    },
    port: 8083,
    allowedHosts: ["localhost", "project.local"],
  },
  optimization: {
    minimize: true,
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },
      {
        test: /\.(css|scss)$/,
        use: [
          {
            loader: "vue-style-loader",
          },
          {
            loader: "css-loader",
            options: {
              importLoaders: 1,
            },
          },
          {
            loader: "postcss-loader",
          },
          {
            loader: "sass-loader",
          },
        ],
      },

      {
        test: /\.(eot|ttf|jpg|otf|jpeg|png|woff|woff2|png|jpe?g|gif)$/i,
        type: "asset",
      },
    ],
  },
  output: {
    path: path.resolve(__dirname, "assets/dist"),
    filename: "flarum_to_wordpress.bundle.js",
  },
  plugins: [
    new VueLoaderPlugin(),
    //new webpack.HotModuleReplacementPlugin(),
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: true,
      __VUE_PROD_DEVTOOLS__: false,
    }),
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
      vue: "@vue/runtime-dom",
    },
    extensions: ["*", ".js", ".vue", ".json", ".css"],
  },
};
