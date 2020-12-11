module.exports = {
    plugins: ['stylelint-scss'],
    extends: [
        'stylelint-config-wordpress',
        'stylelint-config-rational-order',
        // 'stylelint-prettier/recommended',
    ],
    ignoreFiles: ['./src/scss/inc/bass/**/*.scss', './**/*.js', './assets/**'],
    rules: {
        // 'prettier/prettier': [true, { 'singleQuote': false, 'useTabs': true }], //Prettierルールの書き換え？
        'max-line-length': null, //max文字数を無視
        'selector-class-pattern': null,
        // 'indentation': 'tab',
        // 'max-empty-lines': [1, { ignore: ["comments"] }],
        // 'string-quotes': 'double', //ダブルクォーテーションに (wordpress　でそうなってる)
        // 'no-duplicate-selectors': null, //同じセレクタの出現に関するエラーを出さない
        'function-url-quotes': 'never', //不必要なクォーテーションを禁止( 自動Fixできないので注意 )
        'no-descending-specificity': null, //セレクタの詳細度に関する警告を出さない
        // 'number-leading-zero': 'never', //0.5emなどは.5emに  -> Prettierで決められたルールに反するのでナシ
        'font-weight-notation': null, //font-weightの指定は自由
        'font-family-no-missing-generic-family-keyword': null, //sans-serif / serifを必須にするか。object-fitでエラーださないようにする。
        'at-rule-no-unknown': null, //scssで使える @include などにエラーがでないように
        'scss/at-rule-no-unknown': true, //scssでもサポートしていない @ルールにはエラーを出す
        // 'order/properties-alphabetical-order': true, //ABC順
    },
};
