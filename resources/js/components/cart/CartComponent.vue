<template>
  <main>
    <div class="shopping_cart_box">
      <form class="shopping_cart_info" action="index.html" method="post">
        <p class="shopping_cart_title">Shopping Cart</p>
        <div class="select_all">
          <!-- ここに追加 -->
          <ul class="select_items">
            <li v-for="field in fields" :key="field.id">
              <div class="for_table_image">
                <a href="../item_detail/index.html">
                  <img :src="field.img_path" alt="No Image">
                </a>
              </div>
              <div class="products_title_tag">
                <div class="products_title">
                  <a href="../item_detail/index.html">
                    <span id="item_name_00">{{ field.name }}</span>
                  </a>
                </div>
                <div class="products_model_number">{{ field.model }}</div>
                <div class="products_discription">
                  {{ field.comment }}
                </div>
                <!-- change -->
                <div class="products_tag_all">
                  <div class="products_tag">
                    <!--- タグは最大で6つ  ---->
                    <div class="tag_per" id="tag_per_0" v-for="(tag, index) in field.tags" :key="index">
                      <p class="submit_tag">#&thinsp;{{ tag.tag_name }}</p>
                    </div>
                  </div>
                </div>
                <div class="add_info_form">
                  <p>追加情報(任意)：</p>
                  <input type="text" name="add_info" value="" class="add_info_input" v-model="field.remarks">
                </div>
              </div>
              <form class="price_number_form" action="index.html" method="post">
                <div class="products_price">
                  <p>&yen;{{ Number(field.price).toLocaleString() }}</p>
                </div>
                <div class="reconfirm_item_amount">
                  <div class="amount_change_button_all">
                    <quantity-component
                      :index="field.id"
                      :defaultQuantity="field.quantity"
                      ref="quantityreset"
                      v-on:quantity-event="quantityMethod"
                    ></quantity-component>
                  </div>
                  <div class="submit_button_01">
                    <div class="button_cartin_div_01">
                      <button type="button" name="button" class="button_cartin" @click.prevent.stop="updateCart(field.id)">
                        <p>更新する<i class="fas fa-cart-arrow-down"></i></p>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="submit_button">
                  <div class="submit_button_02">
                    <button type="button" name="button" class="delete_button_cartin openModal" @click.prevent.stop="showModal(field.id, field.name)">
                      <p>削除&nbsp;<i class="fas fa-times"></i></p>
                    </button>
                  </div>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <div class="dsp_all_price">
          <p class="dsp_all_price_title">合計金額</p>
          <p class="all_price">&yen;<span>{{ Number(sumprice).toLocaleString() }}</span></p>
        </div>
        <!--- 確認後の編集ボタン、最終登録ボタン  ---->
        <div class="final_resister">
          <router-link to="/items/index" class="button_item_submit_01">
            <i class="fa fa-mail-reply "></i>&emsp;買い物を続ける
          </router-link>
          <a href="#" class="button_item_submit_02" @click.prevent.stop="confirmLink">
            確認画面へ&emsp;<i class="fa fa-mail-forward"></i>
          </a>
        </div>
      </form>
    </div>

    <!-- モーダルエリアここから -->
    <section id="modalArea" class="modalArea" v-bind:class="{show: showFlag, hide: hideFlag, none: noneFlag}">
      <div id="modalBg" class="modalBg"></div>
      <div class="modalWrapper">
        <div class="modalContents">
          <p class="delete_item_title">アイテムの削除</p>
          <p class="delete_item_centence">買い物かごから<span id="delete_item_centence_span">{{ confirmContent }}</span>を削除します。よろしいですか？</p>
          <div class="final_dicision">
            <button type="button" name="button" class="cansellation_delete" id="closeModal" @click.prevent.stop="hideModal">
              キャンセル
            </button>
            <button type="button" name="button" class="dicision_delete" @click.prevent.stop="deleteCart">
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
  data: function(){
    return {
      fields: {
        remarks: ''
      },
      quantityFields: [],
      sumprice: 0,
      deleteId: 0,
      showFlag: false,
      hideFlag: false,
      noneFlag: true,
      confirmContent: '',
    }
  },
  mounted() {
    this.$emit('class-event', 'cart-index');
    axios.get('/api/carts').then(e => {
      this.fields = e.data.data;
      this.fields.forEach(field => {
        this.quantityFields.push({'id':field.id, 'quantity':field.quantity});
        this.sumprice += field.price * field.quantity;
      });
      this.$emit('loading-event', false);
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    showModal: function(id, name) {
      this.deleteId = id;
      this.confirmContent = name;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 200);
    },
    hideModal: function() {
      this.hideFlag = true;
      this.showFlag = false;
      setTimeout(() => {
        this.hideFlag = false;
        this.noneFlag = true;
      }, 600);
    },
    quantityMethod: function(quantity, id) {
      this.quantityFields.forEach(quantityField => {
        if(quantityField.id === id) {
          quantityField.quantity = quantity;
        }
      });
    },
    updateCart: function(id) {
      var quantity = 0;
      this.quantityFields.forEach(quantityField => {
        if(quantityField.id === id) {
          quantity = quantityField.quantity;
        }
      });

      let formData = new FormData()
      formData.append('quantity', quantity);

      axios.post('/api/cart/' + id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        this.fields = e.data.data;
        this.quantityFields = [];
        this.sumprice = 0;
        this.fields.forEach(field => {
          this.quantityFields.push({'id':field.id, 'quantity':field.quantity});
          this.sumprice += field.price * field.quantity;
        });
        this.$emit('message-event', '数量を更新しました.', true);
      }).catch((error) => {
        console.log(error);
      });
    },
    deleteCart: function() {
      axios.delete('/api/cart/' + this.deleteId).then(e => {
        this.fields = e.data.data;
        this.quantityFields = [];
        this.sumprice = 0;
        this.fields.forEach(field => {
          this.deleteId = 0;
          this.confirmContent = '';
          this.quantityFields.push({'id':field.id, 'quantity':field.quantity});
          this.sumprice += field.price * field.quantity;
        });
        this.hideModal();
        this.$emit('message-event', '製品をカートから出しました.', true);
      }).catch((error) => {
        console.log(error);
      });
    },
    confirmLink: function() {
      this.fields.forEach(field => {
        if(field.remarks) {
          var quantity = 0;
          this.quantityFields.forEach(quantityField => {
            if(quantityField.id === field.id) {
              quantity = quantityField.quantity;
            }
          });
          let formData = new FormData()
          formData.append('quantity', quantity);
          formData.append('remarks', field.remarks);

          axios.post('/api/cart/' + field.id, formData, {
            headers: {
              'X-HTTP-Method-Override': 'PUT'
            }
          }).then(e => {
            
          }).catch((error) => {
            console.log(error);
          });
        }else {
          var quantity = 0;
          this.quantityFields.forEach(quantityField => {
            if(quantityField.id === field.id) {
              quantity = quantityField.quantity;
            }
          });
          let formData = new FormData()
          formData.append('quantity', quantity);

          axios.post('/api/cart/' + field.id, formData, {
            headers: {
              'X-HTTP-Method-Override': 'PUT'
            }
          }).then(e => {
            
          }).catch((error) => {
            console.log(error);
          });
        }
      });
      this.$emit('loading-event', true);
      setTimeout(() => {
        this.$router.push({
          name: 'cartconfirm'
        });
      }, 600);
    }
  }
}
</script>