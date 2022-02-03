<template>
  <main>
    <div class="item_resist_box">
      <editpage-component 
        ref="editchild" 
        v-on:fieldset-event="fieldsetMethod" 
        v-on:imageset-event="imagesetMethod" 
        v-on:class-event="classchangeMethod"
      ></editpage-component>
      <editconfirmPage-component 
        ref="confirmchild" 
        v-on:class-event="classchangeRebackMethod" 
        v-on:notificationChange-event="notificationChangeMethod" 
        v-on:message-event="messageMethod"
        v-bind:class="{anim_confirm: hoge_2}"
      ></editconfirmPage-component>
    </div>
  </main>
</template>

<script>
export default {
  data: function(){
    return {
      hoge_1: false,
      hoge_2: false,
    }
  },
  mounted(){
    this.$emit('loading-event', false);
    this.$emit('class-event', 'edit');
    window.onbeforeunload = function () {
      return '保存されていないデータは破棄されます。'
    };
  },
  destroyed () {
    window.onbeforeunload = null
  },
  methods: {
    confirmSave (event) {
      event.returnValue = "編集中のものは保存されませんが、よろしいですか？";
    },
    fieldsetMethod: function(fields){
      this.$refs.confirmchild.fieldSet(fields);
    },
    imagesetMethod: function(url){
      this.$refs.confirmchild.imageSet(url);
    },
    classchangeMethod: function(){
      this.$refs.confirmchild.classChange();
    },
    classchangeRebackMethod: function(){
      this.$refs.editchild.classChange();
    },
    notificationChangeMethod: function() {
      this.$emit('notificationChange-event');
    },
    messageMethod: function(message, bool) {
      this.$emit('message-event', message, bool);
    }
  }
}
</script>