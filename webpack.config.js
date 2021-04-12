const isDev = process.env.NODE_ENV === 'development';
const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const VueLoaderPlugin  = require('vue-loader/lib/plugin')

module.exports = {
    entry: path.resolve(__dirname, 'src/app.js'),
    mode: process.env.NODE_ENV || 'development',
    devServer: {
        host: 'wp.test',
        hot: true,
        headers: { 'Access-Control-Allow-Origin': '*' },
        https: false,
        port: 8080,
        inline: false,
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        publicPath: 'http://wp.test:8080/',
        filename: 'vue-wordpress.js'
    },
    module: {
		rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
              test: /\.css$/,
              use: [
                isDev ? 'style-loader' : MiniCssExtractPlugin.loader,
                'css-loader',
                'postcss-loader'
              ]
              },
        ]
    },
    plugins: [
        new VueLoaderPlugin(),
        new webpack.HotModuleReplacementPlugin(),
        !isDev && new MiniCssExtractPlugin({
          filename: 'vue-wordpress.css'
        }),
      ].filter(Boolean),
    resolve: {
        alias: {
          '@': path.resolve(__dirname, './src')
        },
        extensions: ['*', '.js', '.vue', '.json']
      }
}