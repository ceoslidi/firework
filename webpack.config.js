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
        exclude: /app/js/,
      },
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader"],
	exclude: /app/css/
      },
      {
        test: /\.scss$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
	exclude: /app/css/
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
