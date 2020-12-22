// const webpack = require('webpack');
const path = require('path');

module.exports = {
	mode: 'production',

	// メインとなるJavaScriptファイル（エントリーポイント）
	entry: {
		common: './src/js/common.js',
		ssp: './src/js/ssp.js',
		mediauploader: './src/js/mediauploader.js',
		
	},

	// ファイルの出力設定
	output: {
		path: path.resolve(__dirname, 'dist/js'),
		filename: '[name].js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [
					{
						// Babel を利用する
						loader: 'babel-loader',
						// Babel のオプションを指定する
						options: {
							presets: [
								[
									'@babel/preset-env',
									{
										modules: false,
										useBuiltIns: 'usage', //core-js@3から必要なpolyfillだけを読み込む
										corejs: 3,
										// targets: {
										//     esmodules: true,
										// },
									},
								],
							],
						},
					},
				],
			},
		],
	},
};
