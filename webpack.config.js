const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  plugins: [
    new MiniCssExtractPlugin(),
  ],
  mode: "production",
  devtool: "nosources-source-map",
  module: {
    rules: [
      {
        test: /\.ts$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader"],
      },
      {
        test: /\.scss$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
      {
        test: /\.png/,  // TODO: .jpg, .webp?
        type: "asset",
        parser: {
          dataUrlCondition: {
            maxSize: 10 * 1024,  // 10kb
          },
        },
      },
    ],
  },
  resolve: {
    extensions: [".ts", ".js"],
  },
};
