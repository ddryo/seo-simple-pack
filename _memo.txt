# 投稿フォーマットのテスト時

```
add_theme_support( 'post-formats', [ 'aside', 'gallery' ] );
```

投稿フォーマットのアーカイブURL : /type/aside/
（ is_tax(), is_tax( 'post_format' ) が true となる。）


# 注意点
アーカイブは複数の種類が共存するケースがあるので、generate処理内の条件分岐を統一する。
コアの wp_get_document_title() の条件分岐に合わせて is_post_type_archive > is_term系 > is_author > is_date の順にしておく。

※ ただし、クエリオブジェクト get_queried_object() の取得優先度は WP_Term > WP_Post_Type > WP_User


# 独自スニペットのフック

ex) %_hoge_%

```
add_filter( 'ssp_replace_snippet_hoge', function( $val, $context ) {
	return 'this is hoge snipet';
}, 10, 2 );
```
