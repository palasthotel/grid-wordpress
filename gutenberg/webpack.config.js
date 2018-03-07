module.exports = {
	entry: './grid-block.js',
	output: {
		path: __dirname,
		filename: 'grid-block.built.js',
	},
	module: {
		loaders: [
			{
				test: /.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/,
			},
		],
	}
};
