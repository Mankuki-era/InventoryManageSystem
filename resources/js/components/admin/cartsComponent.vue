<template>
  <main class="main-cart">

    <div class="modal-window" v-bind:class="{show: showFlag, none: noneFlag, hide: hideFlag}">
      <adminmodal-component
        v-on:close-event="closeMethod"
        v-on:refresh-event="refreshAction"
        v-on:message-event="messageMethod"
        v-on:quantityPass-event="quantityUpdateMethod"
        v-on:remarksPass-event="remarksUpdateMethod"
        v-on:resetCart-event="resetCartMethod"
        ref="modalchild"
      ></adminmodal-component>
    </div>
    <div class="modal-mask" v-bind:class="{none: noneFlag}"></div>

    <div class="main-contena">
      <div class="main-title">Cart Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-shopping-cart submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Carts Table</p>
          <div class="no-carts" v-if="!dataFlag">
            <p><i class="fas fa-info-circle info-icon"></i>カートは空です.</p>
          </div>
          <div class="buttons" v-if="dataFlag">
            <li class="add-button"><a href="#" @click.prevent.stop="linkAction('export-confirm', null)"><i class="fas fa-file-download buttons-icon"></i>Export</a></li>
          </div>
          <div class="table">
            <table v-if="dataFlag">
              <div class="admin-loader" v-bind:class="{ hidden: isHide }"></div>
              <div class="admin-mask" v-bind:class="{ hidden: isHide }"></div>
              <thead>
                <tr>
                  <th>製品名</th>
                  <th>型番</th>
                  <th>備考</th>
                  <th>単価</th>
                  <th>数量</th>
                  <th>合計</th>
                  <th>URL</th>
                  <th>削除</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="field in fields" :key="field.id">
                  <td>{{ field.name }}</td>
                  <td>{{ field.model }}</td>
                  <td class="center remarks">
                    <a href="#" @click.prevent.stop="linkAction('remarks-change', field.id, field.remarks)"><i class="fas fa-pen-square fa-lg"></i></a>
                    <span> {{ field.remarks }}</span>
                  </td>
                  <td class="center" v-if="field.price !== 0">{{ field.price }}</td>
                  <td class="center" v-else></td>
                  <td class="center">
                    <a href="#" @click.prevent.stop="linkAction('quantity-change', field.id, field.quantity)">{{ field.quantity }}</a>
                  </td>
                  <td class="center">{{ field.price * field.quantity }}</td>
                  <td><a :href="field.url">{{ field.url }}</a></td>
                  <td class="center">
                    <a href="#" @click.prevent.stop="destroyAction(field.id)"><i class="fas fa-trash-alt action-icon trash-icon"></i></a>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="center">{{ sumprice }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      fields: {},
      sumprice: 0,
      isHide: true,
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
      dataFlag: false
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.loadCarts();
  },
  methods: {
    loadCarts: function(){
      this.isHide = false;
      this.$emit("adminLoading-event", true);
      axios.get('/api/carts').then(e => {
        this.fields = e.data.data;
        this.fields.forEach(field => {
          if(!field.remarks){
            field.remarks = '';
          }
          this.sumprice += field.price * field.quantity;
        });
        if(this.fields.length !== 0) {
          this.dataFlag = true;
        }
        this.isHide = true;
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    linkAction: function(actionName, id, subInfo) {
      this.$refs.modalchild.initFields(actionName, id);
      if(actionName === 'remarks-change') {
        this.$refs.modalchild.remarksInit(subInfo);
      }else{
        this.$refs.modalchild.quantityInit(subInfo);
      }
      this.hideFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 100);
    },
    closeMethod: function() {
      this.showFlag = false;
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
      }, 500);
    },
    refreshAction: function() {
      this.loadUsers();
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    },
    destroyAction: function(id) {
      axios.delete('/api/cart/' + id).then(e => {
        this.fields = e.data.data;
        this.sumprice = 0;
        this.fields.forEach(field => {
          this.sumprice += field.price * field.quantity;
        });
      }).catch((error) => {
        console.log(error);
      });
    },
    quantityUpdateMethod: function(quantity, id) {
      var sumprice = 0;
      this.fields.forEach(field => {
        if(field.id === id) {
          field.quantity = quantity;
        }
        sumprice += field.price * field.quantity;
      });
      this.sumprice = sumprice;
    },
    remarksUpdateMethod: function(remarks, id) {
      this.fields.forEach(field => {
        if(field.id === id) {
          field.remarks = remarks;
        }
      });
    },
    resetCartMethod: function() {
      this.fields = {};
      this.sumprice = 0;
      this.dataFlag = false;
    }
  }
}
</script>