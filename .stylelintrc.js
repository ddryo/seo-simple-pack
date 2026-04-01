module.exports = {
    extends: [
        '@wordpress/stylelint-config',
    ],
    ignoreFiles: ['./src/scss/inc/bass/**/*.scss', './**/*.js', './dist/**'],
    rules: {
        'max-line-length': null,
        'selector-class-pattern': null,
        'function-url-quotes': 'never',
        'no-descending-specificity': null,
        'font-weight-notation': null,
        'font-family-no-missing-generic-family-keyword': null,
        'at-rule-no-unknown': null,
        'scss/at-rule-no-unknown': true,
    },
};
