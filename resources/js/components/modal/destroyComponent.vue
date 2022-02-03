<template>
  <div class="destroy-form-contena">
    <a href="#" class="destroy-button" @click.prevent.stop="destroyAction">Destroy</a>
    <p class="destroy-name">{{ name }}</p>
    <p class="destroy-message"><i class="fas fa-exclamation-triangle alert-icon"></i> データベースから削除してもよろしいですか？</p>
  </div>
</template>

<script>
export default {
  props: ['action_info'],
  data: function(){
    return {
      name: '',
      actionInfo: this.action_info,
    }
  },
  mounted() {
    this.loadNameAction();
  },
  methods: {
    loadNameAction: function() {
      this.name = '';
      if(this.actionInfo.name === 'item-destroy'){
        axios.get('/api/item/' + this.actionInfo.id).then(e => {
          this.name = e.data.data.name;
        }).catch((error) => {
          console.log(error);
        });
      }else if(this.actionInfo.name === 'user-destroy'){
        axios.get('/api/user/' + this.actionInfo.id).then(e => {
          this.name = e.data.name;
        }).catch((error) => {
          console.log(error);
        });
      }else if(this.actionInfo.name === 'thema-destroy'){
        axios.get('/api/thema/' + this.actionInfo.id).then(e => {
          var first_name = e.data.first_category !== "" ? e.data.first_category : "なし";
          var second_name = e.data.second_category !== "" ? e.data.second_category : "なし";
          var third_name = e.data.third_category !== "" ? e.data.third_category : "なし";
          this.name = first_name + " > " + second_name + " > " + third_name;
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    destroyAction: function(){
      if(this.actionInfo.name === 'item-destroy'){
        axios.delete('/api/item/' + this.actionInfo.id).then(e => {
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }).catch((error) => {
          console.log(error);
        });
      }else if(this.actionInfo.name === 'user-destroy'){
        axios.delete('/api/user/' + this.actionInfo.id).then(e => {
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }).catch((error) => {
          console.log(error);
        });
      }else if(this.actionInfo.name === 'thema-destroy'){
        axios.delete('/api/thema/' + this.actionInfo.id).then(e => {
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }).catch((error) => {
          console.log(error);
        });
      }
    }
  }
}
</script>