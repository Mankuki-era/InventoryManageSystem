<template>
  <div class="item_resist_box_01_all" id="item_resist_box_01_all" v-bind:class="{anim_create_hide: hoge_1, anim_create_none: fuga_1, anim_create_show: piyo_1}">
    <div class="item_resist_box_01" id="item_resist_box_01">
      <form class="resist_info_01" method="POST">
        <p class="main_resist_title">Item Resistration</p>
        <div class="resist_all_01">
          <div class="resist_left_div">
            <!--- image upload  ---->
            <p class="named_ID named_ID_image">商品画像</p>
            <div class="for_preview_image_01">
              <img :src="url" alt="photo preview">
            </div>
            <div class="input_file">
              <label for="img_file_upload" class="file_upload">
                <p>+ 写真を選ぶ</p>
                <input type="file" name="item_picture" id="img_file_upload" class="img_file_upload" accept="image/png, image/jpeg" ref="preview" @change="fileSelected">
              </label>
            </div>
          </div>
          <div class="resist_right_div">
            <!--- 商品名の入力  ---->
            <p class="named_ID named_ID_noncaution">商品名<span class="required_mark">&nbsp;*</span> </p>
            <input type="text" name="item_name" value="" class="FormOfms" placeholder="例) セラミック抵抗 470[Ω]" v-model="fields.name" autofocus>
            <p class="caution_message" v-if="errors.name">{{ errors.name }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_00"></p> -->

            <!--- 型番の入力  ---->
            <p class="named_ID">型番<span class="required_mark">&nbsp;*</span> </p>
            <input type="text" name="model_number" value="" class="FormOfms" placeholder="例) RD25S 470K" v-model="fields.model">
            <p class="caution_message" v-if="errors.model">{{ errors.model }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_01"></p> -->

            <!--- 値段入力  ---->
            <p class="named_ID">価格<span class="required_mark">&nbsp;*</span> </p>
            <div class="number_with">
              <p>&yen;</p>
              <input type="number" name="item_price" value="" step="1" class="FormOfms FormOfms_num" placeholder="例) 30000" v-model="fields.price">
            </div>
            <p class="caution_message" v-if="errors.price">{{ errors.price }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_02"></p> -->

            <!--- 初期数量入力  ---->
            <p class="named_ID">在庫数<span class="required_mark">&nbsp;*</span> </p>
            <div class="item_amount_value">
              <input type="number" name="item_amount" value="" step="1" class="FormOfms FormOfms_num" placeholder="例) 100" v-model="fields.stocks">
              <input type="text" name="item_amount_mascot" value="" class="FormOfms FormOfms_num_value" placeholder="例) 個">
            </div>
            <p class="caution_message" v-if="errors.stocks">{{ errors.stocks }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_03"></p> -->

            <div class="needs_division">
              <div>
                <!--- 前期必要数  ---->
                <p class="named_ID">前期必要数<span class="required_mark">&nbsp;*</span> </p>
                <input type="number" name="item_amount" value="" step="1" class="FormOfms FormOfms_needs" placeholder="例) 100" v-model="fields.pro_needs">
                <!-- <p class="caution_message" id="caution_message_03"></p> -->
              </div>
              <div>
                <!--- 後期必要数  ---->
                <p class="named_ID">後期必要数<span class="required_mark">&nbsp;*</span> </p>
                <input type="number" name="item_amount" value="" step="1" class="FormOfms FormOfms_needs" placeholder="例) 100" v-model="fields.late_needs">
                <!-- <p class="caution_message" id="caution_message_03"></p> -->
              </div>
            </div>

            <!--- 通年必要数  ---->
            <p class="named_ID">通年必要数<span class="required_mark">&nbsp;*</span> </p>
            <input type="number" name="item_amount" value="" step="1" class="FormOfms FormOfms_num" placeholder="例) 100" v-model="fields.all_needs">
            <p class="caution_message" v-if="errors.needs">{{ errors.needs }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_03"></p> -->

            <!--- URL入力  ---->
            <p class="named_ID">URL<span class="required_mark">&nbsp;*</span> </p>
            <input type="url" name="item_url" value="" class="FormOfms" v-model="fields.url">
            <p class="caution_message" v-if="errors.url">{{ errors.url }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_04"></p> -->

            <!--- 学年学科、科目名の入力  ---->
            <p class="named_ID">学年学科・科目名<span class="required_mark">&nbsp;*</span> </p>
            <span class="grade_selection_wrap">
              <span class="grade_selection_title" v-show="!fields.selectGrade">学年学科を選択</span>
              <select class="grade_selection" id="grade_selection" v-model="fields.selectGrade" @change="gradeSelected">
                <option disabled selected hidden>学年学科を選択</option>
                <option v-for="grade in gradeList" :key="grade" :value="grade">
                  {{ grade }}
                </option>
              </select>
            </span>
            <span class="List_selection_wrap">
              <span class="List_selection_title" v-show="!fields.selectThema">科目名を選択</span>
              <select class="menuList List_selection" name="menuList" id="menuList" v-model="fields.selectThema">
                <option disabled selected hidden>科目名を選択</option> <!-- 追加 -->
                <option v-for="thema in themaList" :key="thema" :value="thema">
                  {{ thema }}
                </option>
              </select>
            </span>
            <p class="caution_message" v-if="errors.grade_thema">{{ errors.grade_thema }}</p>
            <p class="caution_message" v-else></p>
            <!-- <p class="caution_message" id="caution_message_05"></p> -->

            <!--- タグ情報の追加  ---->
            <p class="named_ID named_ID_noncaution">商品タグ</p>
            <div class="form_area">
              <div v-for="(tag, index) in tagForm" :key="index" class="tag_per">
                <div class="form_area_first">
                  <p>●</p>
                </div>
                <input type="text" name="submit_tag" value=""
                placeholder="例：抵抗" class="submit_tag" v-model="tagForm[index]">
                <button @click.prevent.stop="removeInput(index)" class="delete_tag_form"><p>×</p></button>
              </div>
            </div>
            <button @click.prevent.stop="addInput" class="additional_tag_button"><p>+ タグ追加</p></button>
            <p class="caution_message" v-if="tag_message">{{ tag_message }}</p>
            <p class="caution_message" v-else></p>

            <!--- 詳細情報入力  ---->
            <p class="named_ID named_ID_noncaution">商品説明</p>
            <textarea name="submit_details"
            placeholder="例) 1EC ワークショップで使用。年間に約1億個使う予定。ひるたくんも高校時代から愛用している抵抗値で汎用性が非常に高い。"
            rows="5" class="detail_box" v-model="fields.comment"></textarea>

          </div>
        </div>
        <!--- 最終登録ボタン  ---->
        <div class="final_resister">
          <button type="button" name="button" class="button_item_submit" id="final_resister" @click.prevent.stop="submit">
            確認画面へ&emsp;<i class="fa fa-mail-forward"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      hoge_1: false,
      fuga_1: false,
      piyo_1: false,
      gradeList: [],
      themaList: [],
      fields: {},
      tagForm: [],
      errors: {},
      tag_message: '',
      url: '',
    }
  },
  mounted: function(){
    this.loadGrade();
    axios.get('/api/item/' + this.$route.params.id).then(e => {
      this.fields = e.data.data;
      this.url = e.data.data.img_path;
      var tagsArray = [];
      this.fields.tags.forEach(tag => {
        tagsArray.push(tag.tag_name);
      });
      if(tagsArray){
        tagsArray.forEach(tag => {
          if (tag !== this.fields.first_category && tag !== this.fields.second_category && tag !== this.fields.third_category) {
            this.tagForm.push(tag);
          }
        });
        this.fields.grade_belong = this.fields.first_category;
        this.fields.selectGrade = this.fields.second_category;
        this.gradeSelected();
        this.fields.selectThema = this.fields.third_category;
      }else{
        this.tagForm = [''];
      }
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    loadGrade: function() {
      axios.get('/api/grade').then(e => {
        this.gradeList = e.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    addInput: function() {
      if(this.tagForm.length < 5){
        this.tagForm.push('');
      }else{
        this.tag_message = 'タグは5つまで追加可能です.';
      }
    },
    removeInput: function(index) {
      this.tagForm.splice(index, 1);
      if(this.tagForm.length <= 5){
        this.tag_message = '';
      }
    },
    fileSelected(e) {
      const file = this.$refs.preview.files[0];
      this.url = URL.createObjectURL(file);
      this.fields.img_file = e.target.files[0];
      this.$emit('imageset-event', this.url);
    },
    gradeSelected: function(){
      axios.get('/api/themas', {
        params: {
          'grade': this.fields.selectGrade
        }
      }).then(e => {
        this.fields.grade_belong = e.data.grade_belong;
        this.themaList = e.data.themaList;
      }).catch((error) => {
        console.log(error);
      });
    },
    submit: function() {
      this.errors = {};
      this.setErrors();
      if(this.check()){
        this.setFields();
        this.hoge_1 = true;
        this.piyo_1 = false;
        setTimeout(() => {
          this.fuga_1 = true;
          this.hoge_1 = false;
          this.$emit('class-event');
        }, 600);
        this.$emit('fieldset-event', this.fields);
      }else{
        return;
      };
    },
    setErrors: function(){
      var commonString = 'を入力してください.';
      this.errors.name = this.fields.name ? '' : '商品名' + commonString;
      this.errors.price = this.fields.price ? '' : '単価' + commonString;
      this.errors.stocks = this.fields.stocks ? '' : '在庫数' + commonString;
      if(this.selectgrade === "" && this.selectthema !== ""){
        this.errors.grade_thema = '学年学科を選択してください.';
      }else if(this.selectgrade !== "" && this.selectthema === ""){
        this.errors.grade_thema = '科目名を選択してください.';
      }else if(this.selectgrade === "" && this.selectthema === ""){
        this.errors.grade_thema = '学年学科,科目名を選択してください.';
      }else{
        this.errors.grade_thema = "";
      }
    },
    setFields: function(){
      var tagformFiexed = [];
      var tags = [];
      this.tagForm.forEach(tag => {
        if(tag.trim()){
          tagformFiexed.push(tag.trim());
        }
      });
      if(this.fields.grade_belong === ''){
        tags.push(this.fields.selectGrade, this.fields.selectThema, ...tagformFiexed); //スプレッド関数によって配列を展開してpush
      }else{
        tags.push(this.fields.grade_belong, this.fields.selectGrade, this.fields.selectThema, ...tagformFiexed); //スプレッド関数によって配列を展開してpush
      }
      this.fields.first_category = this.fields.grade_belong;
      this.fields.second_category = this.fields.selectGrade;
      this.fields.third_category = this.fields.selectThema;
      this.fields.tags = tags;
    },
    check: function(){
      for(let key in this.errors){
        if(this.errors[key]){
          return false;
        };
      };
      return true;
    },
    classChange: function(){
      this.fuga_1 = false;
      this.piyo_1 = true;
    }
  }
}
</script>