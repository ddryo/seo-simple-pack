/* eslint no-console: 0 */

const path = require('path');
const fs = require('fs');
const { globSync } = require('glob');

// sass (Dart Sass)
const sass = require('sass');

// postcss
const postcss = require('postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sortMediaQueries = require('postcss-sort-media-queries');

// consoleの色付け
const green = '\u001b[32m';
const red = '\u001b[31m';

// パス
const src = 'src/scss';
const dist = 'dist/css';
const ignore = ['**/_*.scss'];
const files = globSync(src + '/**/*.scss', { ignore });

files.forEach((filePath) => {
	const fileName = filePath.replace(src + '/', '');
	const srcPath = path.resolve(__dirname, src, fileName);
	const distPath = path.resolve(__dirname, dist, fileName).replace('.scss', '.css');

	try {
		const result = sass.compile(srcPath, {
			style: 'compressed',
			silenceDeprecations: ['import'],
		});

		// postcss実行
		postcss([autoprefixer, sortMediaQueries, cssnano])
			.process(result.css, { from: undefined })
			.then((postcssResult) => {
				// ディレクトリがなければ作成
				fs.mkdirSync(path.dirname(distPath), { recursive: true });
				fs.writeFileSync(distPath, postcssResult.css);
				console.log(green + 'Wrote CSS to ' + distPath);
			})
			.catch((err) => {
				console.error(red + 'PostCSS error: ' + err);
			});
	} catch (err) {
		console.error(red + 'Sass error: ' + err);
	}
});
