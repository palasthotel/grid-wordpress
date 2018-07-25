const config = {
    entry: {
        'grid-block': './gutenberg/block/src/grid-block.js',
    },
    output: {
        path: __dirname + '/gutenberg/block',
        filename: '[name].built.js',
        sourceMapFilename: '[name].built.map',
	    libraryTarget: 'window',
    },
	externals: {
		'react': 'React',
		'react-dom': 'ReactDOM',
	},
    devtool: 'source-map',
    module: {
        loaders: [{
            test: /\.(js|jsx)$/,
            exclude: /node_modules/,
            loader: 'babel-loader',
            query: {
                // presets: [
                //     "es2015",
                //     "react"
                // ],
                plugins: ["transform-object-rest-spread"]
            }
        }]
    },
};

if (process.env.NODE_ENV === "production") {
    config.output.filename = "[name].built.js";
    config.output.sourceMapFilename = "[name].built.map";
}

module.exports = config;
