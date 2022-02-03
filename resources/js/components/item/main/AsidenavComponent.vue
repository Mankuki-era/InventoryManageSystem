<template>
  <aside class="category_division" id="aside_bar">
    <ul class="division_of_allitem">
      <li><a href="#" @click.prevent.stop="linkClick(null, null, null)">All Items</a></li>
    </ul>
    <p class="category_division_title">Category</p>
    <ul class="before_grade_division">
      <div class="s_01">
        <!---  1EC  -------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[0].name, null, null)">1EC</a></li>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[0].name, grade[0].course, null)">ワークショップ</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_1ec01" id="theme_division_1ec01">
            <ul>
              <li v-for="(link, index) in EC1_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[0].name, grade[0].course, link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>
        <!---  2EC  ------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[1].name, null, null)">2EC</a></li>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[1].name, grade[1].course, null)">情報通信基礎実験</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_2ec" id="theme_division_2ec">
            <ul>
              <li v-for="(link, index) in EC2_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[1].name, grade[1].course, link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>
        <!---  3EC  -------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[2].name, null, null)">3EC</a></li>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[2].name, grade[2].course, null)">情報通信工学実験</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_3ec" id="theme_division_3ec">
              <ul>
                <li v-for="(link, index) in EC3_link" :key="index">
                  <a href="#" @click.prevent.stop="linkClick(grade[2].name, grade[2].course, link)">{{ link }}</a>
                </li>
              </ul>
          </div>
        </div>
        <!---  4EC  --------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[3].name, null, null)">4EC</a></li>
        <div class="accordion_header_4c"><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[3].name, grade[3].course, null)">情報通信プロジェクト</a></div>
        <!---  2NC  ---------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[4].name, null, null)">2NC</a></li>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[4].name, grade[4].course[0], null)">情報通信基礎実験&nbsp;Ⅰ</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_2nc01" id="theme_division_2nc01">
            <ul>
              <li v-for="(link, index) in NC2_1_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[4].name, grade[4].course[0], link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[4].name, grade[4].course[1], null)">情報通信基礎実験&thinsp;Ⅱ</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_2nc02" id="theme_division_2nc02">
            <ul>
              <li v-for="(link, index) in NC2_2_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[4].name, grade[4].course[1], link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>

        <!---  3NC  ------------------------------------------------------------------------------------------>
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[5].name, null, null)">3NC</a></li>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[5].name, grade[5].course[0], null)">情報通信工学実験&nbsp;Ⅰ</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_3nc01" id="theme_division_3nc01">
            <ul>
              <li v-for="(link, index) in NC3_1_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[5].name, grade[5].course[0], link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="accordion_menu">
          <div class="accordion_header">
            <div><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[5].name, grade[5].course[1], null)">情報通信工学実験&thinsp;Ⅱ</a></div>
            <div class="menu_icon">◀</div>
          </div>
          <div class="accordion_inner theme_division theme_division_3nc02" id="theme_division_3nc02">
            <ul>
              <li v-for="(link, index) in NC3_2_link" :key="index">
                <a href="#" @click.prevent.stop="linkClick(grade[5].name, grade[5].course[1], link)">{{ link }}</a>
              </li>
            </ul>
          </div>
        </div>
        <!---  4NC  ---------------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[6].name, null, null)">4NC</a></li>
        <div class="accordion_header_4c"><a href="#" class="a_color_select" @click.prevent.stop="linkClick(grade[6].name, grade[6].course, null)">情報通信プロジェクト</a></div>
        <!---  管理室内  ----------------------------------------------------------------------------------->
        <li class="before_grade_division_li"><a href="#" @click.prevent.stop="linkClick(grade[7].name, null, null)">management room</a></li>
        <!-------------------------------------------------------------------------------------------------->
      </div>
    </ul>
  </aside>
</template>

<script>
export default {
  mounted() {
    $(function(){
      $('.s_01 .accordion_menu .accordion_header').click(function(){
        //クリックされた.accordion_oneの中の.accordion_headerに隣接する.accordion_innerが開いたり閉じたりする。
        $(this).next('.accordion_inner').slideToggle();
        $(this).toggleClass("open");
        //クリックされた.accordion_oneの中の.accordion_header以外の.accordion_oneの中の.accordion_headerに隣接する.accordion_oneの中の.accordion_innerを閉じる
        $('.s_01 .accordion_menu .accordion_header').not($(this)).next('.accordion_menu .accordion_inner').slideUp();
        $('.s_01 .accordion_menu .accordion_header').not($(this)).removeClass("open");
      });
    });
  },
  data () {
    return {
      grade: [
        {
          name: "1EC",
          course: "ワークショップ"
        },
        {
          name: "2EC",
          course: "情報通信基礎実験"
        },
        {
          name: "3EC",
          course: "情報通信工学実験"
        },
        {
          name: "4EC",
          course: "情報通信プロジェクト"
        },
        {
          name: "2NC",
          course: ["情報通信基礎実験Ⅰ", "情報通信基礎実験Ⅱ"]
        },
        {
          name: "3NC",
          course: ["情報通信工学実験Ⅰ", "情報通信工学実験Ⅱ"]
        },
        {
          name: "4NC",
          course: "情報通信プロジェクト"
        },
        {
          name: "4NC",
          course: "情報通信プロジェクト"
        },
        {
          name: "管理室内",
        },
      ],
      EC1_link: [
        "電源回路の製作",
        "抵抗回路の製作",
        "LANケーブルの作成",
        "コンデンサの測定実験",
        "トランジスタの測定実験",
        "論理回路の基礎実験",
        "Arduinoの実習",
      ],
      EC2_link: [
       "ディジタル技術の基礎",
        "増幅回路基礎",
        "回路網の基礎",
        "周波数と周波数特性の基礎",
        "RLCの実験",
        "Web演習",
        "ロジックの基礎",
        "パソコン組立",
      ],
      EC3_link: [
        "シリアル通信",
        "ディジタル信号処理",
        "振幅変調とその検波",
        "OPアンプ",
        "電波の基礎",
        "論理回路",
        "光ファイバーの伝送特性",
        "表示デバイス",
        "通信用ケーブルの伝送特性",
        "ネットワーク構築",
        "組込みプログラミング",
      ],
      NC2_1_link: [
        "RLCの実験",
        "ディジタル技術の基礎",
        "ネットワークの基礎",
        "パソコン組立",
        "CRTオシロスコープの実験",
      ],
      NC2_2_link: [
        "増幅回路基礎",
        "電波の基礎",
        "マイコン基礎",
        "回路網の実験",
        "周波数特性の基礎",
      ],
      NC3_1_link: [
        "液晶素子の作製とその評価",
        "電波の基礎",
        "OPアンプ",
        "振幅変調とその検波",
        "ルータネットワーク構築",
        "組込みプログラミング",
        "ディジタル信号処理",
      ],
      NC3_2_link: [
        "シリアル通信",
        "論理回路",
        "ディジタル信号処理",
        "VPNとネットワークセキュリティ",
        "光ファイバーの伝送特性",
        "ケーブルの伝送特性",
        "AIの基礎",
      ]
    };
  },
  methods: {
    linkClick: function(first_category, second_category, third_category){
      this.$emit('linkclick-event', first_category, second_category, third_category);
    }
  }
}
</script>