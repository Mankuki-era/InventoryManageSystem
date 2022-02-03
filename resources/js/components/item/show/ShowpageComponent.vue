<template>
  <main>
    <div class="item_resist_box">
      <p class="main_resist_title">Item Details<!---Comfirm Item Resistration Information---></p>
      <div class="for_edit_delete">
        <a href="#" @click.prevent.stop="editpageLink(item.id)"><p class="for_edit">edit&nbsp;<i class="fas fa-edit"></i></p></a>
        <button type="button" name="button" class="delete_modal_button openModal" id="00">
          <p class="for_delete">delete&nbsp;<i class="fas fa-trash-alt"></i></p>
        </button>
      </div>
      <div class="resist_all">
        <div class="resist_left_div">
          <!--- image upload  ---->
          <div class="for_preview_image">
            <img :src="item.img_path" alt="photo preview">
          </div>
        </div>
        <div class="resist_right_div">
          <div class="name_price">
            <!--- 商品名  ---->
            <p class="item_name" id="item_name_00">{{ item.name }}</p>
            <!--- 値段  ---->
            <p class="price_of_items">&yen;&nbsp;{{ Number(item.price).toLocaleString() }}</p>
          </div>
          <div class="amount_cart">
            <div class="amount_cart_first">
              <!--- 初期数量  ---->
              <p class="amount_of_items_title">在庫数量</p>
              <p class="amount_of_items">{{ item.stocks }}</p>
            </div>
            <div class="for_cart_in">
              <quantity-component
                :index="item.id"
                :defaultQuantity="defQuantity"
                ref="quantityreset"
                v-on:quantity-event="quantityMethod"
              ></quantity-component>
              <add-component
                :item="item"
                :flg="item.bool"
                ref="quantity"
                v-on:cartchange-event="cartchangeMethod"
                v-on:messageshow-event="messageshowMethod"
              ></add-component>
            </div>
          </div>
          <p class="info_title">製品情報</p>
          <div class="machanic_info">
            <!--- 型番  ---->
            <p>型番：{{ item.model }}</p>
            <!--- URL  ---->
            <p>URL：<a href="#">{{ item.url }}</a></p>
          </div>
          <div class="division_menu_tag">
            <!--- 学年学科、科目名  ---->
            <div class="grade_division_menu">
              <p class="grade_division">
                カテゴリー：
                <a href="#">{{ item.first_category }}</a>
                <span v-show="item.second_category" style="margin-left: 3px; margin-right: 3px;">></span>
                <a href="#">{{ item.second_category }}</a>
                <span v-show="item.third_category" style="margin-left: 3px; margin-right: 3px;">></span>
                <a href="#">{{ item.third_category }}</a>
              </p>
            </div>
            <!--- タグ  ---->
            <div class="concern_tag">
              <p class="concern_tag_title">関連タグ</p>
              <div id="form_area" class="form_area">
                <div class="tag_per" id="tag_per_0" v-for="(tag, index) in item.tags" :key="index">
                  <div class="form_area_first" id="form_area_first_0">
                    <p id="form_icon_0">●</p>
                  </div>
                  <a href="#" @click.prevent.stop="tagClick(tag.tag_name)"><p class="submit_tag">{{ tag.tag_name }}</p></a>
                </div>
              </div>
            </div>
          </div>

          <!--- 詳細情報  ---->
          <p class="item_discription">商品説明</p>
          <p class="detail_of_items" v-if="item.comment">{{ item.comment }}</p>
          <p class="detail_of_items" v-else>特になし.</p>

        </div>
      </div>
    </div>
    <!-- モーダルエリアここから -->
    <section id="modalArea" class="modalArea">
      <div id="modalBg" class="modalBg"></div>
      <div class="modalWrapper">
        <div class="modalContents">
          <p class="delete_item_title">アイテムの削除</p>
          <p class="delete_item_centence"><span class="delete_item_centence_span">{{ item.name }}</span> を削除します。よろしいですか？</p>
          <div class="final_dicision">
            <button type="submit" name="button" class="cansellation_delete" id="closeModal">
              キャンセル
            </button>
            <button type="button" name="button" class="dicision_delete" @click.prevent.stop="destroy">
              削除
            </button>
          </div>
        </div>
      </div>
    </section>
    <!-- モーダルエリアここまで -->
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      item: {},
      defQuantity: 0
    }
  },
  mounted() {
    this.$emit('class-event', 'show');
    axios.get('/api/item/' + this.$route.params.id).then(e => {
      this.item = e.data.data;
      this.defQuantity = this.item.cart === null ? 0 : this.item.cart.quantity;
      this.$emit('loading-event', false);
    }).catch((error) => {
      console.log(error);
    });
    $(function () {
      $('.openModal').click(function(){
        var get_id = $(this).attr('id');
        var item_name_id = 'item_name_' + get_id;
        var str = $(item_name_id).text();
        $('#delete_item_centence_span').text(str);
        $('#modalArea').fadeIn();
      });
      $('#closeModal , #modalBg').click(function(){
        $('#modalArea').fadeOut();
      });
    });
  },
  methods: {
    editpageLink: function(id){
      this.$router.push({
        name: 'edit',
        params: {
          id: id
        }
      })
    },
    quantityMethod: function(count, index){
      this.$refs.quantity.changequantityMethod(count);
    },
    cartchangeMethod: function(){
      this.$emit('cartchange-event');
    },
    messageshowMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    },
    destroy: function(){
      axios.delete('/api/item/' + this.$route.params.id).then(e => {
        this.$emit('notificationChange-event');
        this.$emit('message-event', e.data.message, true);
        this.$router.push({ name: "index" });
      }).catch((error) => {
        console.log(error);
      });
    }
  }
}
</script>