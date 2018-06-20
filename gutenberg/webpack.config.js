const config = {
    entry: {
        block: './block/src/grid-block.js',
    },
    output: {
        path: __dirname + '/block',
        filename: '[name].built.js',
        sourceMapFilename: '[name].map',
    },
    devtool: 'source-map',
    module: {
        loaders: [{
            test: /\.(js|jsx)$/,
            exclude: /node_modules|bower_components/,
            loader: 'babel-loader',
            query: {
                presets: ["es2015", "react"],
                plugins: ["transform-object-rest-spread"]
            }
        }]
    },
};

if (process.env.NODE_ENV == "production") {
    config.output.filename = "[name].built.js";
    config.output.sourceMapFilename = "[name].built.map";
}

module.exports = config;
