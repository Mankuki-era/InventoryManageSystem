### アプリケーション名
　**在庫管理システム**
 
### アプリケーションの概要
　**大学の実験室で使用する機材の在庫状況を管理するシステムです**   
 
### 工夫した点
- バックエンドはフレームワークを使用せずにより軽量で保守しやすくしました。
- コメント記述を適度にしてコードを見やすくする工夫をしました。
- Vue.jsとCSSのファイル改装を統一してデザインしやすくしました。
- Vue.jsにおいて共通部分はコンポーネント化しました。

### 改善点
- 現在, Vue.js, JQuery共にCDNを使用しているため, 本番環境では使用をやめる予定です。

### その他
　大学実験室内のみで使用するためローカルで開発
 
### アプリケーションで使っている技術
- データベース: MySQL 5.7.26
- 開発環境: MAMP 4.2.0
- 言語: PHP 7.4.2, Vue.js 2.6.14, JQuery 3.6.0

### アプリケーションの機能
- 製品の登録（一括登録, 一行登録）
- 製品一覧の確認（学年ごとの表示可能）
- 検索機能（全文検索可能）
- お気に入り登録
- 製品情報の編集, 削除
- ページネーション
