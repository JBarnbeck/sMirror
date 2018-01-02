const path = require('path');
const webpack = require('webpack');

module.exports = {
    entry: {
        news: './assets/src/js/news.js',
    },
    output: {
        path: path.join(__dirname, 'assets/dist/js/'), 
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env'],
                    },
                },
            },
        ],
    },
};