<template>
  <div class="login_form_all" v-bind:class="{hide_first: hide_1, show_first: show_1, none_first: none_1}">
    <div class="login_form_left">
      <div class="login_form_title">
        <div class="h_area">
          <h1>
            <p class="h1_sub">情報通信工学科実験室</p>
            <p class="main_title2">在庫管理システム</p>
            <p class="main_title2">ログインフォーム</p>
          </h1>
        </div>
      </div>
    </div>
    <div class="login_form_right">
      <div class="login_input">
        <form method="POST" class="login_form" @submit.prevent.stop="loginUser">
          <h2>LOGIN</h2>
          <div class="input_staff_number">
            <p class="named_ID">STAFF NUMBER</p>
            <input type="number" name="staff_number" value="" maxlength="5" step="1" class="FormOfms" v-model="form.number" autofocus>
            <p class="caution_message" v-if="errors.number">{{errors.number[0]}}</p>
            <p class="caution_message" v-else></p>
          </div>
          <div class="input_password">
            <p class="named_ID">PASSWORD</p>
            <input type="password" name="password" value="" class="FormOfms" v-model="form.password">
            <p class="caution_message" v-if="errors.password">{{errors.password[0]}}</p>
            <p class="caution_message" v-else></p>
          </div>
          <button type="submit" value="Login" class="login_button">Login<!---ログイン---></button>
          <p class="signup_message">アカウントを登録していない方は<a href="#" @click.prevent.stop="registerLink">こちら</a></p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      form:{
        number: '',
        password: ''
      },
      errors: {},
      hide_1: false,
      show_1: false,
      none_1: false,
    }
  },
  methods:{
    loginUser(){
      axios.post('/api/login', this.form).then((e) =>{
        this.errors = {};
        if(!e.data.status){
          return;
        }
        if(e.data.admin){
          this.$router.push({
            name: 'admindashboard',
            params: {
              showAnimationFlag: true
            }
          });
        }else{
          this.$router.push({ 
            name: "index",
            params: {
              authFlag: true
            }
          }); 
        }
      }).catch((error) =>{
        this.errors = error.response.data.errors;
      })
    },
    registerLink(){
      this.hide_1 = true;
      this.show_1 = false;
      setTimeout(()=>{
        this.none_1 = true;
        this.hide_1 = false;
      }, 1000);
      this.$emit('class-event');
    },
    classChange(){
      this.none_1 = false;
      this.hide_1 = false;
      this.show_1 = true;
    }
  }
}
</script>