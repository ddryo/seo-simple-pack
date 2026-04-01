# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## プロジェクト概要

SEO SIMPLE PACK — WordPress用のシンプルなSEOプラグイン。メタタグ・OGPタグの設定とカスタマイズを提供する。

- テキストドメイン: `seo-simple-pack`
- テストスイートは存在しない。コード品質チェックは `composer phpcs` のみ。

## アーキテクチャ

### エントリポイント

`seo-simple-pack.php` → `plugins_loaded` フックで `SEO_SIMPLE_PACK` クラスをインスタンス化。`init` フック（priority 0）で Data / Menu / MetaBox を初期化。

### メタタグ出力フロー

1. `SSP_Output::generate()` — `wp_head` priority 0 でメタデータ生成
2. `pre_get_document_title` フィルターでタイトルを返却
3. `SSP_Output::main()` — `wp_head` priority 5 でHTML出力

スニペット変数: `%_site_title_%`, `%_sep_%`, `%_page_title_%`, `%_page_contents_%`, `%_term_name_%` 等

全主要タグに `ssp_output_*` フィルターあり（`ssp_output_og_title`, `ssp_output_og_image` 等）。

### 投稿メタキー

`ssp_meta_robots`, `ssp_meta_title`, `ssp_meta_description`, `ssp_meta_keyword`, `ssp_meta_canonical`, `ssp_meta_image`

## コーディング規約

- WordPress Coding Standards準拠（`phpcs.xml` でカスタマイズ済み）
- 配列は短縮構文 `[]` を使用（`array()` 禁止）
- PHP短縮タグ `<?= ?>` 許可
- Yoda記法不要
- 変数・関数名の snake_case 強制なし
- 名前空間: メインクラスはグローバル、ヘルパーは `LOOS\SSP`、トレイトは `SSP`

## デプロイ

GitHubでバージョンタグをプッシュすると、GitHub Actionsが自動でWordPress.orgへSVNデプロイを実行。

## バージョン更新手順

1. `readme.txt` の Stable tag を更新
2. `readme.txt` のチェンジログを追加
3. `seo-simple-pack.php` のプラグインヘッダコメントのバージョンを更新
