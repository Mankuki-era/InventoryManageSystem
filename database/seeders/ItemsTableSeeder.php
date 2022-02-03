<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('items')->insert([
            [
            'name' => 'ピンヘッダ 1×40 (40p)',
            'url' => 'https://akizukidenshi.com/catalog/g/gC-00167/',
            'model' => null,
            'comment' => '2.54mmピッチタイプです。シングルインラインタイプ(1列タイプ)。',
            'price' => 35,
            'stocks' => 100,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'name' => 'ユニバーサル基盤 Ｃタイプ めっき仕上げ (72×42mm)',
            'url' => null,
            'model' => 'PH-2x46gQ',
            'comment' => 'もっとも良く使われるユニバーサル基板です。',
            'price' => 60,
            'stocks' => 60,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
            [
            'name' => 'バナナプラグ(赤色)',
            'url' => 'https://akizukidenshi.com/catalog/g/gC-10116/',
            'model' => 'MK-621-0',
            'comment' => 'テスターリード等に使われるストレート型のバナナプラグです。',
            'price' => 45,
            'stocks' => 78,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
            [
            'name' => '丸ピンICソケット (8P)',
            'url' => 'https://akizukidenshi.com/catalog/g/gP-00035/',
            'model' => '2227MC-08-03',
            'comment' => '高信頼、長寿命の丸ピンソケットです。',
            'price' => 15,
            'stocks' => 189,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
            [
            'name' => 'ブレッドボード',
            'url' => 'https://akizukidenshi.com/catalog/g/gP-05294/',
            'model' => 'BB-801',
            'comment' => 'いま人気上昇中のはんだごてを使わずに電子工作ができるボードです。部品の組み換えがすぐにできますので思いついたことがすぐに実行できます。簡単な回路の製作や電子回路のアイデアのテスト等に最適です。BB-801は、ブレッドボードの中でも特に人気の、E-CALL社EIC801(P-00315)と同じ配線パターンとなっています。',
            'price' => 200,
            'stocks' => 50,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
            [
            'name' => '電解コンデンサー 100μF25V85℃',
            'url' => 'https://akizukidenshi.com/catalog/g/gP-03122/',
            'model' => '25PK100MEFC5X11',
            'comment' => 'ルビコンの一般用電解コンデンサーです。',
            'price' => 10,
            'stocks' => 130,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
            [
            'name' => 'カーボン抵抗(炭素被膜抵抗) 1/4W 10kΩ (100本入り)',
            'url' => 'https://akizukidenshi.com/catalog/g/gR-25103/',
            'model' => 'RD25S 10K',
            'comment' => '使いやすくて高信頼の炭素皮膜抵抗(カーボン抵抗)です。工業製品、家電等に幅広く使用されています。',
            'price' => 100,
            'stocks' => 200,
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],   
        ]);
    }
}
