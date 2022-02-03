<template>
  <main class="login">
    <login-component 
    ref="loginchild" 
    v-on:message-event="messageMethod"
    v-on:class-event="classMethod"
    ></login-component>
    <register-component 
    ref="registerchild" 
    v-on:message-event="messageMethod"
    v-on:class-event="classRebackMethod"
    ></register-component>
  </main>
</template>

<script>
export default {
  props: ["logoutFlag", "showAnimationFlag"],
  mounted() {
    if(this.showAnimationFlag !== undefined){
      this.$emit('class-event', 'auth', true);
    }else{
      this.$emit('class-event', 'auth');
    }
    if(this.logoutFlag !== undefined){
      this.$emit('message-event', 'ログアウトしました.', true);
    }
  },
  methods: {
    classMethod: function(){
      this.$refs.registerchild.classChange();
    },
    classRebackMethod: function(){
      this.$refs.loginchild.classChange();
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    }
  }
}
</script>