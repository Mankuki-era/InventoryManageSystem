<template>
  <div class="item_resist_box_02_all" id="item_resist_box_02_all" v-bind:class="{anim_confirm_hide: hoge_2, anim_confirm_none: fuga_2}">
    <div class="item_resist_box_02" id="item_resist_box_02">
      <div class="resist_info_02">
        <p class="main_resist_title_02">最終確認画面</p>
        <div class="resist_all_02">
          <div class="resist_left_div">
            <!--- image upload  ---->
            <div class="for_preview_image_02">
              <img :src="url" alt="photo preview">
            </div>
          </div>
          <div class="resist_right_div">
            <div class="name_price">
              <!--- 商品名  ---->
              <p class="item_name">{{ fields.name }}</p>
              <!--- 値段  ---->
              <p class="price_of_items">&yen;&nbsp;{{ fields.price | numberWithDelimiter }}</p>
            </div>
            <div class="amount_cart">
              <div class="amount_cart_first">
                <!--- 初期数量  ---->
                <p class="amount_of_items_title">在庫数</p>
                <p class="amount_of_items">{{ fields.stocks }}</p>
              </div>
              <div class="amount_cart_first">
                <!--- 前期必要数量  ---->
                <p class="amount_of_items_title">前期必要数</p>
                <p class="amount_of_items">{{ fields.stocks }}</p>
              </div>
              <div class="amount_cart_first">
                <!--- 後期必要数量  ---->
                <p class="amount_of_items_title">後期必要数</p>
                <p class="amount_of_items">{{ fields.stocks }}</p>
              </div>
              <div class="amount_cart_first">
                <!--- 通年必要数量  ---->
                <p class="amount_of_items_title">通年必要数</p>
                <p class="amount_of_items">{{ fields.stocks }}</p>
              </div>
            </div>
            <p class="info_title">製品情報</p>
            <div class="machanic_info">
              <!--- 型番  ---->
              <p>型番：{{ fields.model }}</p>
              <!--- URL  ---->
              <p>URL：{{ fields.url }}</p>
            </div>
            <div class="division_menu_tag">
              <!--- 学年学科、科目名  ---->
              <div class="grade_division_menu">
                <p class="grade_division">
                  <span>カテゴリー：</span>
                  <span>{{ fields.firstlink }}</span>
                  <span v-show="fields.secondlink" style="margin-left: 3px; margin-right: 3px;">></span>
                  <span>{{ fields.secondlink }}</span>
                  <span v-show="fields.thirdlink" style="margin-left: 3px; margin-right: 3px;">></span>
                  <span style="margin-left: 3px;">{{ fields.thirdlink }}</span>
                </p>
              </div>
              <!--- タグ  ---->
              <div class="concern_tag">
                <p class="concern_tag_title">関連タグ</p>
                <div id="form_area" class="form_area">
                  <!--- タグは最大で6つ  ---->
                  <div class="tag_per" id="tag_per_0" v-for="(tag, index) in fields.tags" :key="index">
                    <div class="form_area_first" id="form_area_first_0">
                      <p id="form_icon_0">●</p>
                    </div>
                    <p class="submit_tag">{{ tag }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!--- 詳細情報  ---->
            <p class="item_discription">商品説明</p>
            <p class="detail_of_items" v-if="fields.comment">{{ fields.comment }}</p>
            <p class="detail_of_items" v-else>特になし</p>

          </div>
        </div>
        <!--- 確認後の編集ボタン、最終登録ボタン  ---->
        <div class="final_resister_02">
          <button type="button" name="button" class="button_item_submit_01" id="final_resister_02" @click.prevent.stop="reback">
            <i class="fa fa-mail-reply "></i>&emsp;編集へ戻る
          </button>
          <button type="button" name="button" class="button_item_submit_02" @click.prevent.stop="submit">
            作成
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      fields: {},
      url: '/image/no_image.png',
      hoge_2: false,
      fuga_2: true,
    }
  },
  filters: {
    numberWithDelimiter(value) {
      if(!value) return '0';
      return value.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1, ');
    }
  },
  methods: {
    imageSet: function(url){
      this.url = url;
    },
    fieldSet: function(fields){
      this.fields = {};
      this.fields = fields;
    },
    submit: function() {
      let formData = new FormData();
      formData.append('name', this.fields.name);
      formData.append('price', this.fields.price);
      formData.append('stocks', this.fields.stocks);
      formData.append('tags', this.fields.tags);
      formData.append('first_category', this.fields.first_category);
      formData.append('second_category', this.fields.second_category);
      formData.append('third_category', this.fields.third_category);
      if(this.fields.model){
        formData.append('model',this.fields.model);
      }
      if(this.fields.url){
        formData.append('url',this.fields.url);
      }
      if(this.fields.img_file){
        formData.append('file',this.fields.img_file);
      }
      if(this.fields.comment){
        formData.append('comment', this.fields.comment);
      }

      axios.post('/api/item', formData).then(e => {
        this.$emit('notificationChange-event');
        this.$emit('message-event', e.data.message, true);
        this.$router.push({ name: "index" });
      }).catch((error) => {
        console.log(error);
      });
    },
    classChange: function(){
      this.fuga_2 = false;
    },
    reback: function(){
      this.fuga_2 = true;
      setTimeout(()=>{
        this.$emit('class-event');
      }, 200);
    }
  }
}
</script>