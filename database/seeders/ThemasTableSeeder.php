<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themas')->insert([
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => '電源回路の製作',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => '抵抗回路の製作',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => 'LANケーブルの作成',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => 'コンデンサの測定実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => 'トランジスタの測定実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => '論理回路の基礎実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '1EC',
            'second_category' => 'ワークショップ',
            'third_category' => 'Arduinoの実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => 'ディジタル技術の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => '増幅回路基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => '回路網の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => '周波数と周波数特性の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => 'RLCの実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => 'Web演習',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => 'ロジックの基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2EC',
            'second_category' => '情報通信基礎実験',
            'third_category' => 'パソコン組立',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => 'シリアル通信',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => 'ディジタル信号処理',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '振幅変調とその検波',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => 'OPアンプ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '電波の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '光ファイバーの伝送特性',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '表示デバイス',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '通信用ケーブルの伝送特性',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => 'ネットワーク構築',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3EC',
            'second_category' => '情報通信工学実験',
            'third_category' => '組込みプログラミング',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4EC',
            'second_category' => '情報通信プロジェクトEC',
            'third_category' => '消耗品',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅰ',
            'third_category' => 'RLCの実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅰ',
            'third_category' => 'ディジタル技術の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅰ',
            'third_category' => 'ネットワークの基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅰ',
            'third_category' => 'パソコン組立',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅰ',
            'third_category' => 'CRTオシロスコープの実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅱ',
            'third_category' => '増幅回路基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅱ',
            'third_category' => '電波の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅱ',
            'third_category' => 'マイコン基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅱ',
            'third_category' => '回路網の実験',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '2NC',
            'second_category' => '情報通信基礎実験Ⅱ',
            'third_category' => '周波数と周波数特性の基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => 'アンテナの基本特性',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => 'OPアンプ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => '振幅変調とその検波',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => 'ルータネットワーク構築',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => '組込みプログラミング',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅰ',
            'third_category' => 'ディジタル信号処理',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '液晶素子の作製と評価',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => 'シリアル通信',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '論理回路',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => 'ディジタル信号処理',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => 'VPNとネットワークセキュリティ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => '光ファイバーの伝送特性',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => 'ケーブルの伝送特性',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '3NC',
            'second_category' => '情報通信工学実験Ⅱ',
            'third_category' => 'AIの基礎',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'アンテナ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'アプリを究める',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'ネットワーク',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'マルチメディアと信号処理',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'IoT機器',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '4NC',
            'second_category' => '情報通信プロジェクトNC',
            'third_category' => 'Linuxサーバー',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
            [
            'first_category' => '',
            'second_category' => '管理室内',
            'third_category' => 'なし',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
