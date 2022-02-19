const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: './app/index.js',
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
                test: /\.s[ac]ss$/i,
                use: [
                    "style-loader",
                    "css-loader",
                    "sass-loader",
                ],
            },
        ],
    },
    resolve: {
        extensions: [".ts", ".js"],
    },
    output: {
        path: './dist',
        filename: 'index_bundle.js'
    }
};
