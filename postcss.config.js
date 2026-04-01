module.exports = {
	plugins: [
		require('autoprefixer')({
			cascade: false,
		}),
		require('postcss-sort-media-queries'),
		require('cssnano')({
			preset: 'default',
		}),
	],
};
