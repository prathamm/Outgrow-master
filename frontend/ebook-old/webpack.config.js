var webpack = require("webpack");

module.exports = {
    entry: {
        "app": "./app/main.ts",
        "vendor": "./app/vendor.ts",
        "polyfills": "./app/polyfills.ts"
    },
    output: {
        path: __dirname,
        filename: "./dist/[name].bundle.js"
    },
    resolve: {
        extensions: ['', '.js', '.ts']
    },
    devtool: 'source-map',
    module: {
        loaders: [
            {
                test: /\.ts/,
                loaders: ['ts-loader'],
                exclude: /node_modules/
            }
        ]
    }
}
