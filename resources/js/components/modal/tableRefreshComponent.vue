<template>
  <div class="refresh-form-contena">
    <a href="#" class="refresh-button" @click.prevent.stop="refreshAction">Refresh</a>
    <div class="modal-content">
      <h1>Choose Refresh Table</h1>
      <div class="check-contena">

        <div class="check-contena-box">
          <li class="checkbox item" @click.prevent.stop="checkAction('item')" v-bind:class="{checkItem: refreshBool.item}">
            <i class="fas fa-shopping-bag check-icon item-icon" v-bind:class="{checkIcon: refreshBool.item, noncheckIcon: !refreshBool.item}"></i>
          </li>
          <p v-bind:class="{checkItem: refreshBool.item}">Item Table</p>
        </div>
        <div class="check-contena-box">
          <li class="checkbox notification is-checked" @click.prevent.stop="checkAction('notification')" v-bind:class="{checkNotification: refreshBool.notification}">
            <i class="fas fa-bell check-icon notification-icon" v-bind:class="{checkIcon: refreshBool.notification, noncheckIcon: !refreshBool.notification}"></i>
          </li>
          <p v-bind:class="{checkNotification: refreshBool.notification}">Notification Table</p>
        </div>
        <div class="check-contena-box">
          <li class="checkbox history is-checked" @click.prevent.stop="checkAction('history')" v-bind:class="{checkHistory: refreshBool.history}">
            <i class="fas fa-history check-icon history-icon" v-bind:class="{checkIcon: refreshBool.history, noncheckIcon: !refreshBool.history}"></i>
          </li>
          <p v-bind:class="{checkHistory: refreshBool.history}">History Table</p>
        </div>

      </div>
      <p class="caution_message" v-show="nonCheckFlag">リフレッシュするテーブルを選択してください.</p>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      refreshBool: {
        item: false,
        notification: false,
        history: false
      },
      nonCheckFlag: false,
    }
  },
  methods: {
    refreshAction: function() {
      this.nonCheckFlag = false;
      if(this.refreshBool.item === false && this.refreshBool.notification === false && this.refreshBool.history === false){
        this.nonCheckFlag = true;
        return;
      }

      if(this.refreshBool.item === true && this.refreshBool.notification === false && this.refreshBool.history === false){
        this.refreshItem();
      }else if(this.refreshBool.item === false && this.refreshBool.notification === true && this.refreshBool.history === false){
        this.refreshNotification();
      }else if(this.refreshBool.item === false && this.refreshBool.notification === false && this.refreshBool.history === true){
        this.refreshHistory();
      }else {
        axios.post('/api/refreshItem').then(e => {
          axios.post('/api/refreshNotification').then(e => {
            this.refreshHistory();
          }).catch((error) => {
            console.log(error);
          });
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    refreshItem: function() {
      axios.post('/api/refreshItem').then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$emit('close-event');
        this.$emit('refresh-event');
      }).catch((error) => {
        console.log(error);
      });
    },
    refreshNotification: function(){
      axios.post('/api/refreshNotification').then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$emit('close-event');
        this.$emit('refresh-event');
      }).catch((error) => {
        console.log(error);
      });
    },
    refreshHistory: function(){
      axios.post('/api/refreshHistory').then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$emit('close-event');
        this.$emit('refresh-event');
      }).catch((error) => {
        console.log(error);
      });
    },
    checkAction(name){
      this.nonCheckFlag = false;
      if(name === 'item') {
        this.refreshBool.item = !this.refreshBool.item;
      }else if(name === 'notification'){
        this.refreshBool.notification = !this.refreshBool.notification;
      }else if(name === 'history'){
        this.refreshBool.history = !this.refreshBool.history;
      }
    }
  }
}
</script>