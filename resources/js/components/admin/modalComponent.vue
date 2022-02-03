<template>
  <div class="modal-contena">
    <div class="modal-contena-logo">
      <i class="fas fa-plus submain-contena-icon" v-show="actionInfo.name === 'item-create' || actionInfo.name === 'user-create' || actionInfo.name === 'thema-create'"></i>
      <i class="fas fa-pen submain-contena-icon" v-show="actionInfo.name === 'item-edit' || actionInfo.name === 'user-edit' || actionInfo.name === 'thema-edit' || actionInfo.name === 'remarks-change'"></i>
      <i class="fas fa-eye submain-contena-icon" v-show="actionInfo.name === 'item-show' || actionInfo.name === 'user-show'"></i>
      <i class="fas fa-trash-alt submain-contena-icon" v-show="actionInfo.name === 'item-destroy' || actionInfo.name === 'user-destroy' || actionInfo.name === 'thema-destroy'"></i>
      <i class="fas fa-cog submain-contena-icon" v-show="actionInfo.name === 'admin-pass' || actionInfo.name === 'table-refresh' || actionInfo.name === 'import-data'"></i>
      <i class="fas fa-exclamation-triangle submain-contena-icon" v-show="actionInfo.name === 'export-confirm'"></i>
      <i class="fas fa-plus submain-contena-icon" v-show="actionInfo.name === 'quantity-change' || actionInfo.name === 'stocks-change'"></i>
      <i class="fas fa-minus submain-contena-icon" v-show="actionInfo.name === 'quantity-change' || actionInfo.name === 'stocks-change'"></i>
      <i class="fas fa-cart-arrow-down submain-contena-icon" v-show="actionInfo.name === 'cart-in'"></i>
    </div>
    <div class="modal-main">
      <p class="modal-title" v-if="!(actionInfo.name === 'remarks-change' || actionInfo.name === 'export-confirm' || actionInfo.name === 'quantity-change')">{{ modalTitle }}</p>
      <div class="buttons" v-if="!(actionInfo.name === 'remarks-change' || actionInfo.name === 'export-confirm' || actionInfo.name === 'quantity-change')">
        <li class="back-button"><a href="#" @click.prevent.stop="backLink"><i class="fas fa-backward buttons-icon"></i>Back</a></li>
      </div>

      <!-- item-create, item-edit -->
      <itemCreateEditModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-if="actionInfo.name === 'item-create' || actionInfo.name === 'item-edit'"
      ></itemCreateEditModal-component>
      
      <!-- item-show -->
      <itemShowModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-else-if="actionInfo.name === 'item-show'"
      ></itemShowModal-component>
      
      <!-- user-create, user-edit -->
      <userCreateEditModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'user-create' || actionInfo.name === 'user-edit'"
      ></userCreateEditModal-component>

      <!-- user-show -->
      <userShowModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-else-if="actionInfo.name === 'user-show'"
      ></userShowModal-component>

      <!-- thema-create, thema-edit -->
      <themaCreateEditModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'thema-create' || actionInfo.name === 'thema-edit'"
      ></themaCreateEditModal-component>

      <!-- destroy -->
      <destroy-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'item-destroy' || actionInfo.name === 'user-destroy' || actionInfo.name === 'thema-destroy'"
      ></destroy-component>

      <!-- admin-pass -->
      <adminPassChange-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'admin-pass'"
      ></adminPassChange-component>

      <!-- table-refresh -->
      <tableRefresh-component
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'table-refresh'"
      ></tableRefresh-component>

      <!-- import-data -->
      <importData-component
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-else-if="actionInfo.name === 'import-data'"
      ></importData-component>

      <!-- remarks-component -->
      <cartModal-component
      :action_info="actionInfo"
      :remarks_info="remarksInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-on:remarksPass-event="remarksPassMethod"
      v-else-if="actionInfo.name === 'remarks-change'"
      ></cartModal-component>

      <!-- export-confirm -->
      <cartModal-component
      :action_info="actionInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-on:resetCart-event="resetCartMethod"
      v-else-if="actionInfo.name === 'export-confirm'"
      ></cartModal-component>

      <!-- quantity-change -->
      <cartModal-component
      :action_info="actionInfo"
      :quantity_info="quantityInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-on:quantityPass-event="quantityPassMethod"
      v-else-if="actionInfo.name === 'quantity-change'"
      ></cartModal-component>

      <!-- cart-in -->
      <cartModal-component
      :action_info="actionInfo"
      :item_info="itemInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-on:quantityPass-event="quantityPassMethod"
      v-on:cartchange-event="cartChangeMethod"
      v-else-if="actionInfo.name === 'cart-in'"
      ></cartModal-component>

      <!-- stocks-change -->
      <cartModal-component
      :action_info="actionInfo"
      :item_info="itemInfo"
      v-on:close-event="backLink"
      v-on:refresh-event="refreshMethod"
      v-on:message-event="messageMethod"
      v-on:quantityPass-event="quantityPassMethod"
      v-on:stocksChange-event="stocksChangeMethod"
      v-else-if="actionInfo.name === 'stocks-change'"
      ></cartModal-component>

    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      actionInfo: {},
      modalTitle: '',
      quantityInfo: 0,
      remarksInfo: '',
      itemInfo: {},
    }
  },
  methods: {
    backLink: function() {
      this.$emit('close-event');
      setTimeout(() => {
        this.actionInfo = {};
        this.modalTitle = '';
      }, 500);
    },
    initFields: function(actionName, id) {
      this.actionInfo.name = actionName;
      this.actionInfo.id = id;
      if(actionName === 'item-create') {
        this.modalTitle = "Items Create";
      }
      if(actionName === 'item-show') {
        this.modalTitle = "Items Show";
      }
      if(actionName === 'item-edit') {
        this.modalTitle = "Items Edit";
      }
      if(actionName === 'item-destroy'){
        this.modalTitle = 'Item Destroy';
      }
      if(actionName === 'user-create'){
        this.modalTitle = 'Users Create';
      }
      if(actionName === 'user-show'){
        this.modalTitle = 'Users Show';
      }
      if(actionName === 'user-edit'){
        this.modalTitle = 'Users Edit';
      }
      if(actionName === 'user-destroy'){
        this.modalTitle = 'User Destory';
      }
      if(actionName === 'thema-create'){
        this.modalTitle = 'Themas Create';
      }
      if(actionName === 'thema-edit'){
        this.modalTitle = 'Themas Edit';
      }
      if(actionName === 'thema-destroy'){
        this.modalTitle = 'Thema Destory';
      }
      if(actionName === 'admin-pass'){
        this.modalTitle = 'Admin Pass Change';
      }
      if(actionName === 'table-refresh'){
        this.modalTitle = 'Table Refresh';
      }
      if(actionName === 'import-data'){
        this.modalTitle = 'Import Data';
      }
      if(actionName === 'remarks-change'){
        this.modalTitle = 'Remarks Change';
      }
      if(actionName === 'export-confirm'){
        this.modalTitle = 'Export Confirm';
      }
      if(actionName === 'quantity-change'){
        this.modalTitle = 'Quantity Change';
      }
      if(actionName === 'cart-in'){
        this.modalTitle = 'Cart In';
      }
      if(actionName === 'stocks-change'){
        this.modalTitle = 'Stocks Change';
      }
    },
    quantityInit: function(quantity) {
      this.quantityInfo = quantity;
    },
    itemSet: function(item) {
      this.itemInfo = item;
    },
    remarksInit: function(remarks) {
      this.remarksInfo = remarks;
    },
    refreshMethod: function(){
      this.$emit('refresh-event');
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    },
    quantityPassMethod: function(quantity, id) {
      this.$emit('quantityPass-event', quantity, id);
    },
    remarksPassMethod: function(remarks, id) {
      this.$emit('remarksPass-event', remarks, id);
    },
    cartChangeMethod: function(id, quantity) {
      this.$emit('cartchange-event', id, quantity);
    },
    resetCartMethod: function() {
      this.$emit('resetCart-event');
    },
    stocksChangeMethod: function(id, quantity, bool) {
      this.$emit('stocksChange-event', id, quantity, bool);
    }
  }
}
</script>