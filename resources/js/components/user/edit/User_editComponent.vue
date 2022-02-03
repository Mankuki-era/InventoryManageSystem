<template>
  <main>
    <div class="item_resist_box">
      <p class="main_resist_title">My Account Edition</p>
      <div class="resist_all">
        <div class="change_img_div">
          <div class="for_preview_image">
            <label for="change_img" class="change_img_lav">
              <img :src="url" alt="photo preview">
              <input type="file" name="profile_img" value="" id="change_img" class="change_img_input" accept="image/png, image/jpeg" ref="preview" @change="fileSelected">
            </label>
          </div>
          <div class="plus_mark">
            <i class="fas fa-plus-circle"></i>
          </div>
        </div>
        <div class="account_main_div">
          <div class="account_main_div_first">
            <input type="text" name="account_name" value="" class="account_name" v-model="user.familyName">
            <input type="text" name="account_name" value="" class="account_name" v-model="user.givenName">
          </div>
          <!-- <p class="account_name">Hiruta Riku</p> -->
          <div class="account_main_div_second">
            <p class="staff_num">Staff Number :</p>
            <input type="number" name="staff_num" value="" class="staff_num staff_num_input" v-model="user.number">
            <!-- <p class="staff_num">Staff Number : 90811</p> -->
          </div>
        </div>
        <div class="account_personal_info">
          <div class="personal_info_title">
            <p><i class="fas fa-user"></i>&nbsp;Personal Infomation</p>
          </div>
          <div class="personal_info_div">
            <div class="mail_address_div">
              <p><i class="fas fa-envelope"></i>&nbsp;E-mail&nbsp;:&emsp;</p>
              <input type="email" name="mail_address" value="" class="mail_address_input" v-model="user.email">
            </div>
            <div class="timezone_div">
              <p><i class="far fa-clock"></i>&nbsp;Job timezone&nbsp;:&emsp;</p>
              <div class="select_timezone_all">
                <form action="index.html" method="post">
                  <div class="select_timezone_div">
                    <p class="select_timezone_p" id="select_timezone_p">
                      <span class="select_timezone_p_span" v-show="user.role === 'DAYTIME'">Day Time(AM 10:10 - PM 5:10)</span>
                      <span class="select_timezone_p_span" v-show="user.role === 'NIGHTTIME'">Night Time(PM 5:00 - PM 9:00)</span>
                      &emsp;<i class="fas fa-angle-down"></i>
                    </p>
                    <ul class="select_menu" id="select_menu_timezone">
                      <li class="select_job_timezone selected" @click.prevent.stop="daytimeSelect">Day Time(AM 10:10 - PM 5:10)</li>
                      <li class="select_job_timezone" @click.prevent.stop="nighttimeSelect">Night Time(PM 5:00 - PM 9:00)</li>
                    </ul>
                  </div>
                </form>
              </div>
            </div>
            <p class="administrator_p"><i class="fas fa-users-cog"></i>&nbsp;Administrator Rights&nbsp;:&emsp;Assigned</p>
          </div>
        </div>
      </div>
      <!--- キャンセルボタン、最終登録ボタン  ---->
      <div class="final_resister">
        <button type="button" name="button" class="button_item_submit_01" id="final_resister_02" @click.prevent.stop="cancelAction">
          <i class="fa fa-mail-reply "></i>&emsp;キャンセル
        </button>
        <button type="button" name="button" class="button_item_submit_02" @click.prevent.stop="updateAction">
          更新
        </button>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      user: {},
      url: '',
    }
  },
  mounted() {
    this.$emit('class-event', 'user-edit');
    axios.get('/api/user/' + this.$route.params.id).then(e => {
      this.user = e.data;
      this.url = this.user.img_path;
      var name = this.user.name.split(' ');
      this.user.familyName = name[0];
      this.user.givenName = name[1];
      this.$emit('loading-event', false);
    }).catch((error) => {
      console.log(error);
    });
    $(function(){
      $(document).on('click',function(e) {
        if(!$(e.target).closest('#select_timezone_p').length) {
          $('#select_menu_timezone').slideUp(300);
        }
      });
      $('#select_timezone_p').click(function(){
        $('#select_menu_timezone').slideToggle(300);
      });
      $('.select_job_timezone').on('click',function(event) {
        $('.select_job_timezone').removeClass("selected");
        $(this).addClass("selected");
        var str = $(this).text();
        $('#select_timezone_p_span').text(str);
        $('#select_menu_timezone').slideUp(300);
      });
    });
  },
  methods: {
    daytimeSelect: function() {
      this.user.role = 'DAYTIME';
    },
    nighttimeSelect: function() {
      this.user.role = 'NIGHTTIME';
    },
    fileSelected(e) {
      const file = this.$refs.preview.files[0];
      this.url = URL.createObjectURL(file);
      this.user.file = e.target.files[0];
    },
    cancelAction: function() {
      this.$router.push({
        name: 'usershow',
        params: {
          id: this.user.id
        }
      });
    },
    updateAction: function() {
      let formData = new FormData()
      formData.append('familyName', this.user.familyName);
      formData.append('givenName', this.user.givenName);
      formData.append('email', this.user.email);
      formData.append('number', this.user.number);
      formData.append('role', this.user.role);
      if(this.user.file){
        formData.append('file', this.user.file);
      }

      axios.post('/api/user/' + this.user.id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$router.push({ name: "index" });
      }).catch((error) => {
        console.log(error);
      });
    }
  }
}
</script>