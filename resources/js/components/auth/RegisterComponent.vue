<template>
  <div class="signup_form_all" v-bind:class="{hide_second: hide_2, show_second: show_2, none_second: none_2}">
    <div class="signup_form_left">
      <div class="signup_form_title">
        <div class="h_area">
          <h1>
            <p class="h1_sub main_title">情報通信工学科実験室</p>
            <p class="main_title2">在庫管理システム</p>
            <p class="main_title2">新規会員登録フォーム</p>
          </h1>
        </div>
      </div>
    </div>
    <div class="signup_form_right">
      <div class="signup_control">
        <h2>SIGN UP</h2>
        <form class="staff_info_signup" method="POST" @submit.prevent.stop="saveForm">
          <div class="staff_name">
            <!--- 名字の入力欄  ---->
            <div class="family_name">
              <p class="named_ID">FAMILY NAME <span class="required_mark">*</span> </p>
              <input type="text" name="staff_family_name" value="" class="FormOfms" autocomplete="family-name" v-model="form.familyName">
              <p class="caution_message" v-if="errors.familyName">{{errors.familyName[0]}}</p>
              <p class="caution_message" v-else></p>
            </div>
            <!--- 名前の入力欄  ---->
            <div class="given_name">
              <p class="named_ID">GIVEN NAME <span class="required_mark">*</span> </p>
              <input type="text" name="staff_given_name" value="" class="FormOfms" autocomplete="given-name" v-model="form.givenName">
              <p class="caution_message" v-if="errors.givenName">{{errors.givenName[0]}}</p>
              <p class="caution_message" v-else></p>
            </div>
          </div>
          <!--- 職番の入力  ---->
          <div class="input_box">
            <p class="named_ID">STAFF NUMBER <span class="required_mark">*</span> </p>
            <input type="number" name="staff_number" value="" maxlength="5" step="1" class="FormOfms FormOfms_01" v-model="form.number">
            <p class="caution_message" v-if="errors.number">{{errors.number[0]}}</p>
            <p class="caution_message" v-else></p>
          </div>

          <!--- メールアドレス入力  ---->
          <div class="input_box">
            <p class="named_ID">MAIL ADDRESS <span class="required_mark">*</span> </p>
            <input type="email" name="submit_mail" value="" class="FormOfms FormOfms_01" v-model="form.email">
            <p class="caution_message"  v-if="errors.email">{{errors.email[0]}}</p>
            <p class="caution_message" v-else></p>
          </div>

          <!--- パスワード入力  ---->
          <div class="input_box">
            <p class="named_ID">PASSWORD <span class="required_mark">*</span> </p>
            <input type="password" name="submit_password" value="" class="FormOfms FormOfms_01" id="submit_password" autocomplete="new-password" v-model="form.password">
            <p class="caution_message" v-if="errors.password">{{errors.password[0]}}</p>
            <p class="caution_message" v-else></p>
          </div>

          <!--- パスワード確認入力  ---->
          <div class="input_box">
            <p class="named_ID">CONFIRM PASSWORD <span class="required_mark">*</span> </p>
            <input type="password" name="confirm_password" value="" class="FormOfms FormOfms_01" autocomplete="new-password" v-model="form.password_confirmation">
          </div>

          <!--- 昼夜勤の判断のためのボタン  ---->
          <div class="input_box">
            <p class="named_ID">DAYTIME OR NIGHTTIME <span class="required_mark">*</span> </p>
            <fieldset>
              <!--- 昼勤の選択ボタン  ---->
              <input id="DAYTIME" type="radio" name="day_or_night" value="DAYTIME" class="day_or_night" v-model="form.role" required>
              <label for="DAYTIME" class="job_timezone">DAYTIME</label>
              <!--- 夜勤の選択ボタン  ---->
              <input id="NIGHTTIME" type="radio" name="day_or_night" value="NIGHTTIME" class="day_or_night" v-model="form.role">
              <label for="NIGHTTIME" class="job_timezone">NIGHTTIME</label>
              <!--- 教授の選択ボタン  ---->
              <input id="TEACHER" type="radio" name="day_or_night" value="TEACHER" class="day_or_night" v-model="form.role">
              <label for="TEACHER" class="job_timezone">TEACHER</label>
            </fieldset>
          </div>

          <!--- 管理者権限を付与するかどうかのボタン  ---->
          <div class="input_box input_box_02">
            <p class="named_ID">ADMINISTRATOR RIGHTS <span class="required_mark">*</span> </p>
            <fieldset>
              <!--- 管理者にはならない人向けの選択ボタン  ---->
              <input id="nonassignment" type="radio" name="assignment_or_not" value="nonassignment" class="assignment_or_not" v-model="form.admin" >
              <label for="nonassignment" class="adm_rights">NONASSIGNMENT</label>
              <!--- 管理者になる人向けの選択ボタン  ---->
              <input id="assignment" type="radio" name="assignment_or_not" value="assignment" class="assignment_or_not" v-model="form.admin">
              <label for="assignment" class="adm_rights">ASSIGNMENT</label>
            </fieldset>
          </div>

          <!--- 管理者になる人に課すパスワード入力欄 ---->
          <div class="password_for_assignment" id="password_for_assignment">
            <p class="named_ID pw_box">CONFIRM PASSWORD FOR ASSIGNMENT <span class="required_mark">*</span> </p>
            <input type="password" name="password" value="" class="FormOfms pw_box FormOfms_01" id="pw_box_adm" v-model="adminPassword">
            <p class="caution_message" v-if="message">{{ message }}</p>
            <p class="caution_message" v-else></p>
          </div>

          <!-- プロフのサムネ選び -->
          <p class="named_ID">PROFILE IMAGE</p>
          <div class="input_file">
            <label for="img_file_upload" class="file_upload">
              <p>+ SELECT PHOTO</p>
              <input type="file" name="item_picture" id="img_file_upload" class="img_file_upload">
            </label>
          </div>

          <!--- 最終登録ボタン  ---->
          <div class="final_resister">
            <button type="submit" value="Signup" class="signup_button">Sign Up</button>
            <button type="button" class="signup_button" @click.prevent.stop="loginLink">ログインはこちら</button>
          </div>
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
        familyName: '',
        givenName: '',
        number: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
        admin: 'nonassignment',
        img_file: ''
      },
      adminPassword: '',
      errors:[],
      message: '',
      hide_2: false,
      show_2: false,
      none_2: true,
    }
  },
  methods:{
    loginLink: function(){
      this.hide_2 = false;
      this.show_2 = true;
      this.$emit('class-event');
      setTimeout(()=>{
        this.none_2 = true;
      }, 1000);
    },
    fileSelected(e) {
      this.form.img_file = e.target.files[0];
    },
    saveForm(){
      if(this.form.admin === 'assignment' && this.adminPassword === ''){
        this.message = '管理者用のパスワードを入力してください.';
        return;
      }
      let formData = new FormData();
      formData.append('admin_pass', this.adminPassword);
      formData.append('familyName', this.form.familyName);
      formData.append('givenName', this.form.givenName);
      formData.append('number', this.form.number);
      formData.append('email', this.form.email);
      formData.append('password', this.form.password);
      formData.append('password_confirmation', this.form.password_confirmation);
      formData.append('role', this.form.role);
      formData.append('admin', this.form.admin);
      formData.append('file',this.form.img_file);

      axios.post('/api/register', formData).then((e) =>{
        if(e.data.caution_message){
          this.message = e.data.caution_message;
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
    classChange(){
      this.none_2 = false;
      this.hide_2 = true;
      this.show_2 = false;
    }
  }
}
$(function() {
  $(document).on('click',function(event) {
    var $elementReference = document.getElementById('pw_box_adm');
    if($(event.target).closest('#nonassignment').length) {
      $('#password_for_assignment').slideUp(300);
      $elementReference.required = false;
    }
    if($(event.target).closest('#assignment').length) {
      $('#password_for_assignment').slideDown(300);
      $elementReference.required = true;
    }
  });
});
</script>