<template>
  <div class="cart-form-contena">

    <!-- エクスポート確認用 -->
    <p class="export-message" v-if="actionInfo.name === 'export-confirm'"><i class="fas fa-exclamation-triangle alert-icon"></i> エクスポートしますか？</p>

    <!-- 備考変更用 -->
    <div class="form-input" v-else-if="actionInfo.name === 'remarks-change'">
      <input type="text" name="remarks" v-model="remarks" required>
      <div class="underline"></div>
      <label for="">備考</label>
    </div>

    <!-- カート数量変更用 -->
    <quantity-component
      v-else-if="actionInfo.name === 'quantity-change'"
      :index="actionInfo.id"
      :defaultQuantity="quantity"
      v-on:quantity-event="quantityMethod"
    ></quantity-component>

    <!-- カート追加用 -->
    <div class="cart-card" v-else-if="actionInfo.name === 'cart-in'">
      <img :src="item.img_path" alt="">
      <div class="right-box">
        <h1>{{ item.name }}</h1>
        <quantity-component
          :index="actionInfo.id"
          :defaultQuantity=0
          v-on:quantity-event="quantityMethod"
        ></quantity-component>
        <li class="cartIn-button"><a href="#" @click.prevent.stop="cartInAction">カートに入れる</a></li>
      </div>
    </div>

    <!-- 在庫数変更用 -->
    <div class="stocks-card" v-else-if="actionInfo.name === 'stocks-change'">
      <img :src="item.img_path" alt="">
      <div class="right-box">
        <h1>{{ item.name }}</h1>
        <div class="form-contena">
          <div class="radio-box">
            <input type="radio" name="s2" id="on" value="true" checked="" v-model="bool">
            <label for="on" class="switch-on">納入</label>
            <input type="radio" name="s2" id="off" value="false" v-model="bool">
            <label for="off" class="switch-off">消費</label>
          </div>
          <quantity-component
            :index="actionInfo.id"
            :defaultQuantity=0
            v-on:quantity-event="quantityMethod"
          ></quantity-component>
        </div>
        <li class="stocksUpdate-button"><a href="#" @click.prevent.stop="stocksChangeAction">更新</a></li>
      </div>
    </div>

    <!-- カート追加以外用ボタン -->
    <div class="buttons" v-if="actionInfo.name !== 'cart-in' && actionInfo.name !== 'stocks-change'">
      <li class="cancel-button"><a href="#" @click.prevent.stop="cancelAction">Cancel</a></li>
      <li class="ok-button"><a href="#" @click.prevent.stop="okAction">OK</a></li>
    </div>
  </div>
</template>

<script>
export default {
  props: ['action_info', 'quantity_info', 'remarks_info', 'item_info'],
  data() {
    return {
      actionInfo: this.action_info,
      remarks: this.remarks_info,
      quantity: this.quantity_info,
      item: this.item_info,
      bool: true,
    }
  },
  methods: {
    cancelAction: function() {
      this.$emit('close-event');
    },
    okAction: function(){

      if(this.actionInfo.name !== 'export-confirm') {
        let formData = new FormData()
        if(this.actionInfo.name !== 'cart-in') {
          if(this.actionInfo.name === 'remarks-change') {
            formData.append('remarks', this.remarks);
          }else{
            formData.append('quantity', this.quantity);
          }
    
          axios.post('/api/cart/' + this.actionInfo.id, formData, {
            headers: {
              'X-HTTP-Method-Override': 'PUT'
            }
          }).then(e => {
            if(this.actionInfo.name === 'remarks-change') {
              this.$emit('remarksPass-event', this.remarks, this.actionInfo.id);
            }else{
              this.$emit('quantityPass-event', this.quantity, this.actionInfo.id);
            }
            this.$emit('close-event');
          }).catch((error) => {
            console.log(error);
          });
        }else{

        }
      }else{
        window.location.href = '/carts/export_view';
        setTimeout(() => {
          axios.post('/api/refreshCart').then(e => {
            this.$emit('resetCart-event');
            this.$emit('close-event');
          }).catch((error) => {
            console.log(error);
          });
        }, 1000);
      }
    },
    cartInAction: function() {
      if(this.quantity === 0){
        this.$emit('message-event', '数量を選択してください.', false);
        return
      }else{
        axios.get('/api/cart', {
          params: {
            'id': this.item.id,
            'quantity': this.quantity
          }
        }).then(e => {
          this.$emit('cartchange-event', this.item.id, this.quantity);
          this.$emit('message-event', 'カートに入れました.', true);
          this.$emit('close-event');
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    stocksChangeAction: function() {
      let formData = new FormData();
      formData.append('stocks', this.quantity);
      formData.append('bool', this.bool);
      formData.append('item_name', this.item.name);

      axios.post('/api/item/stocks/' + this.item.id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$emit('stocksChange-event', this.item.id, this.quantity, this.bool);
        this.$emit('close-event');
      }).catch((error) => {
        console.log(error);
      });
    },
    quantityMethod: function(quantity) {
      this.quantity = quantity;
    },
    remarksMethod: function(remarks) {
      this.remarks = remarks;
    }
  }
}
</script>