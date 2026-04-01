// const webpack = require('webpack');
const path = require('path');

module.exports = {
	mode: 'production',

	// メインとなるJavaScriptファイル（エントリーポイント）
	entry: {
		switch: './src/js/switch.js',
		ssp: './src/js/ssp.js',
		mediauploader: './src/js/mediauploader.js',
		
	},

	// ファイルの出力設定
	output: {
		path: path.resolve(__dirname, 'dist/js'),
		filename: '[name].js',
	},
};
