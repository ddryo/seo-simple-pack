#!/bin/bashx

#使い方 : bash ./bin/update.sh 2-0-0

#引数 : プラグインのバージョン
version=$1

#上の階層へ
cd ..

#zプラグインファイルをip化
zip -r seo-simple-pack-${version}.zip seo-simple-pack -x "*._*" "*__MACOSX*" "*.DS_Store" "*.git*" "*.vscode*" "*/_nouse/*" "*/bin/*" "*/node_modules/*" "*/vendor/*"

#設定ファイル系削除
zip --delete seo-simple-pack.zip  "seo-simple-pack/.*"

#zipファイルを移動
# mv seo-simple-pack.zip ./zip/seo-simple-pack-${version}.zip
