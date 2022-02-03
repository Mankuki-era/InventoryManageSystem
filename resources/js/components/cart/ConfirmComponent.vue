<template>
  <main>
    <div class="shopping_cart_box">
      <form class="shopping_cart_info" method="post">
        <p class="shopping_cart_title">Shopping Cart</p>
        <br>
        <div class="select_all">
          <div class="select_items_head">
            <div class="select_items_head_name">
              <p>商品</p>
            </div>
            <div class="select_items_head_per_price">
              <p>単価</p>
            </div>
            <div class="select_items_head_item_amount">
              <p>個数</p>
            </div>
            <div class="select_items_head_acc_price">
              <p>金額</p>
            </div>
          </div>
          <ul class="select_items">
            <li v-for="cart in carts" :key="cart.id">
              <div class="for_table_image">
                <img :src="cart.img_path" alt="No Image">
              </div>
              <div class="products_title_tag">
                <div class="products_title">{{ cart.name }}</div>
                <div class="products_model_number">{{ cart.model }}</div>
                <div class="products_discription">
                  {{ cart.comment }}
                </div>
                <!-- change -->
                <div class="products_tag_all">
                  <div class="products_tag">
                    <!--- タグは最大で6つ  ---->
                    <div class="tag_per" id="tag_per_0" v-for="(tag, index) in cart.tags" :key="index">
                      <p class="submit_tag">#&thinsp;{{ tag.tag_name }}</p>
                    </div>
                  </div>
                </div>
                <div class="add_info_form">
                  <p>追加情報(任意)：{{cart.remarks }}</p>
                </div>
              </div>
              <div class="products_price">
                <p>&yen;{{ Number(cart.price).toLocaleString() }}</p>
              </div>
              <div class="item_amount_all">
                <p>{{ cart.quantity }}個</p>
              </div>
              <div class="products_price_all">
                <p>&yen;{{ Number(cart.price * cart.quantity).toLocaleString() }}</p>
              </div>
            </li>
          </ul>
        </div>
        <div class="dsp_all_price">
          <p class="dsp_all_price_title">合計金額</p>
          <p class="all_price">&yen;<span>{{ Number(sumprice).toLocaleString() }}</span></p>
        </div>
        <!--- 確認後の編集ボタン、最終登録ボタン  ---->
        <div class="final_resister">
          <a href="#" class="button_item_submit_01" @click.prevent.stop="rebackLink">
            <i class="fa fa-mail-reply "></i>&emsp;買い物かごへ戻る
          </a>
          <a href="#" class="button_item_submit_02" @click.prevent.stop="exportAction"><i class="far fa-file-excel"></i>&emsp;Excel出力へ</a>
        </div>
      </form>
    </div>
  </main>
</template>

<script>
export default {
  data: function(){
    return {
      carts: {},
      sumprice: 0,
    }
  },
  mounted() {
    this.$emit('class-event', 'cart-confirm');
    axios.get('/api/carts').then(e => {
      this.carts = e.data.data;
      this.carts.forEach(cart => {
        this.sumprice += cart.price * cart.quantity;
      });
      this.$emit('loading-event', false);
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    rebackLink: function(){
      this.$emit('loading-event', true);
      this.$router.push({
        name: 'cart'
      });
    },
    exportAction: function(){
      window.location.href = '/carts/export_view';
      setTimeout(() => {
        this.$router.push({
          name: 'index'
        });
      }, 2000);
    }
  }
}
</script>