=== SEO SIMPLE PACK ===
Contributors: looswebstudio
Donate link: https://loos-web-studio.com/
Tags: SEO, meta, analytics, webmaster, simple, japan, meta tag
Requires at least: 4.6
Tested up to: 5.5
Stable tag: 1.2.9
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

日本向けに作られたシンプルなSEOプラグインです。ページ種別・投稿ごとにmetaタグやOGPタグを簡単に設定・カスタマイズできます。

== Description ==

「SEO SIMPLE PACK」は、日本向けに作られたシンプルなSEOプラグインです。
SEO対策に必須な `title`タグや`description`タグ、その他基本的な`meta`・`OGP`タグ を簡単に設定・カスタマイズすることができます。

また、ウェブマスターツールやGoogleアナリティクスのコードも、とても簡単に埋め込むことができます。

当プラグインの詳細な説明については[ こちらのページ ](https://wemo.tech/1670)をご覧ください。


= インストール・有効化したら =
何もしなくても問題なく動作し、各ページに適切なタグが出力されます。

しかし、最低でも**ホームのdescriptionタグ**用の設定（初期設定では「キャッチフレーズ」が適用されます）と、**OGP画像**の設定をすることを推奨します。


= 動作しない時は？ =
当プラグインはPHPバージョン5.6以降でのみ動作します。
ご使用のPHPバージョンをご確認ください。

*PHPバージョンが問題ないのに動かない場合、お手数ですが[ こちらのページ ](https://wemo.tech/1670)からコメントでお知らせください。*


= 初期設定について =
重要なページについてのみ簡単に説明しておきます。詳しくは実際の設定画面をご確認ください。

- ホームの`<title>`タグ：「サイト名 | キャッチフレーズ」
- ホームの`<description>`タグ：「キャッチフレーズ」
- 投稿・固定ページの`<title>`タグ：「そのページのタイトル | サイト名」
- 投稿・固定ページの`<description>`タグ：「そのページのコンテンツ（エディタ内文章）から自動生成」
- noindex(follow)となるページ：アーカイブページ・404ページ・検索結果ページ
- 使用不可（リダイレクトによりアクセス禁止）のページ：投稿者アーカイブ・投稿フォーマットアーカイブ・メディア個別ページ

*※「サイト名」および「キャッチフレーズ」とは、WordPressの標準設定の項目で入力している内容です。*


= 設定の編集方法 =
WordPress管理画面の左メニューに「SIMPLE SEO」という項目が追加されているので、クリックしてください。
「一般設定」と「OGP設定」の2種類の管理画面にて、各種設定を行います。


= 一般設定画面 =
サイトの全体的な設定を行います。
投稿ページ・タクソノミーページ・その他アーカイブページなど、各ページ種別ごとに設定が可能です。
投稿ページに関しては、投稿ごとにカスタムフィールドが設置され、個別の設定が可能です。


= OGP設定画面 =
OGP画像の選択や、Facebook・Twitter用の設定をカスタマイズすることができます。

*※投稿系ページのOGP画像は、アイキャッチ画像が優先されます。*


= アナリティクスコード =
トラッキングIDを入力している場合、Googleアナリティクスのトラッキングコードを自動挿入します。
新しい`gtag.js`でのコードで埋め込むか、古い`analytics.js`によるコードで埋め込むかを選択できます。


= 投稿・固定ページの個別設定 =
投稿・固定ページ・カスタム投稿では、その投稿の編集ページ内にメタボックスが追加されており、個別で`description`や`robots`の内容を設定することができます。


== Installation ==


= 自動インストール =
1. プラグインの検索フィールドより「SEO SIMPLE PACK」と入力します。
2. 当プラグインを見つけたら、"今すぐインストール"をクリックしてインストールし、有効化してください。

= 手動インストール =
1.「seo-simple-pack」フォルダ全体を /wp-content/plugins/ ディレクトリにアップロードします。
2.「プラグイン」メニューからプラグインを有効化します。

== Frequently Asked Questions ==
= titleタグが２重になる =
wp_head内( `_wp_render_title_tag` )で出力される`title`タグは削除するようにしていますが、`<head>`内に直接書き込んでいる場合は２重になってしまいます。
手書きの`title`タグを削除してお使いください。

= 特定のページで出力内容を上書きしたい =
出力されるほとんどのタグの出力には`apply_filters`を使用していますので、`add_filter`で上書きが可能です。
主なfilter名は以下の通りです。
・'ssp_output_title'
・'ssp_output_robots'
・'ssp_output_description'
・'ssp_output_canonical'
・'ssp_output_keyword'
・ and more...

詳しくは[ こちらのページ ](https://wemo.tech/1670)でご覧ください。


== Screenshots ==
1. 「基本設定」画面
2. 「Googleアナリティクスコード」設定画面


== Changelog ==

= 1.2.9 =
Fixed translation.

= 1.2.8 =
- Fixed some code.
- Added a little English translation.

= 1.2.7 =
Increased the priority of hooks that output meta tags.

= 1.2.6 =
Fixed bug in 1.2.5.

= 1.2.5 =
Fixed a bug that the description setting of the tag page was not reflected.

= 1.2.4 =
Update to support WordPress 5.3.

= 1.2.3 =
- 著者アーカイブのメタタグが管理者の名前で表示されてしまう不具合を修正
- カスタム投稿・タクソノミーのベース設定が変更できない不具合を修正

= 1.2.2 =
- ホームページの表示設定で設定している「投稿ページ」にトップページと同じ内容のメタタグが出力されてしまう不具合を修正

= 1.2.1 =
- カテゴリー・タグの各タームのアーカイブページごとに title / description / robots の設定ができるようになりました。
- スニペットタグ「%_term_description_%」を追加。
- タームアーカイブのdescriptionのデフォルトを「%_term_description_%」に変更
- descriptionからショーコードを排除する仕様に変更


= 1.2.0 =
WordPress最新版への対応

= 1.1.9 =
コードの微調整

= 1.1.8 =
・項目説明の改善
・（むやみに触ると混乱するので）投稿ページのデフォルト設定からディスクリプションタグに関する設定を非表示に。これまで通り、デフォルトでディスクリプションタグはコンテンツから自動生成されます。

= 1.1.7 =
管理画面の表示の改善

= 1.1.6 =
バグフィックス
(カスタム投稿タイプ・カスタムタクソノミーの設定読み取り順序を後ろに)

= 1.1.5 =
apply_filtersの設定漏れを修正

= 1.1.4 =
1.1.3の通知が動作しなかったので再度更新

= 1.1.3 =
1.1アップデートに伴う重大な変更を管理画面にて通知する設定を追加

= 1.1.1 =
1.1アップデートに伴うバグフィックス

= 1.1.0 =
コードの改善 & 機能改善。
・主なタグの出力に`apply_filters`を適用し、好きに出力内容を上書きできるようにしました。
・個別ページで設定できるrobotsタグについて、より詳細に指定できるようになりました。
・PHP5.6より低いバージョンで使用するとシンタックスエラーが出るため、バージョンに関するメッセージを出して動作させないようにしました。

= 1.0.9 =
他プラグインに影響を与える致命的なバグを改善。その他管理画面の微調整、コードの改善

= 1.0.8 =
スクリプトのjQuery依存を軽減

= 1.0.7 =
Update "Plugin URI".

= 1.0.6 =
バグフィックス

= 1.0.5 =
バグフィックス

= 1.0.4 =
管理画面内の表示改善・記事個別のnoindex設定を「反転するかどうか」に変更・readmeの更新

= 1.0.3 =
descriptionタグの上限値を120文字から300文字に引き上げました

= 1.0.2 =
Add code to remove action "_wp_render_title_tag".

= 1.0.1 =
Changed readme.txt.

= 1.0 =
Initial working version.
