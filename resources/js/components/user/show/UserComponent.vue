<template>
  <main>
    <div class="item_resist_box">
      <p class="main_resist_title">My Account</p>
      <div class="for_edit_page">
        <a href="#" @click.prevent.stop="usereditPage"><p class="for_edit">edit&nbsp;<i class="fas fa-edit"></i></p></a>
      </div>
      <div class="resist_all">
        <div class="for_preview_image">
          <img :src="user.img_path" alt="photo preview">
        </div>
        <div class="account_main_div">
          <p class="account_name">{{ user.name }}</p>
          <p class="staff_num">Staff Number : {{ user.number }}</p>
        </div>
        <div class="account_personal_info">
          <div class="personal_info_title">
            <p><i class="fas fa-user"></i>&nbsp;Personal Infomation</p>
          </div>
          <div class="personal_info_div">
            <p><i class="fas fa-envelope"></i>&nbsp;E-mail&nbsp;:&emsp;{{ user.email }}</p>
            <p v-show="user.role === 'DAYTIME'"><i class="far fa-clock"></i>&nbsp;Job timezone&nbsp;:&emsp;Day Time(AM 10:10 - PM 17:10)</p>
            <p v-show="user.role === 'NIGHTTIME'"><i class="far fa-clock"></i>&nbsp;Job timezone&nbsp;:&emsp;Night Time(PM 5:00 - PM 9:00)</p>
            <p><i class="fas fa-users-cog"></i>&nbsp;Administrator Rights&nbsp;:&emsp;{{ user.admin }}</p>
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
      user: {},
    }
  },
  mounted() {
    this.$emit('class-event', 'user-show');
    axios.get('/api/user/' + this.$route.params.id).then(e => {
      this.user = e.data;
      this.$emit('loading-event', false);
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    usereditPage: function() {
      this.$emit('loading-event', true);
      this.$router.push({
        name: 'useredit',
        params: {
          id: this.user.id
        }
      });
    }
  }
}
</script>