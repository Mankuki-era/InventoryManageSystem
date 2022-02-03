<template>
  <div class="show-form-contena">
    <div class="profile-image-box">
      <img :src="fields.img_path" alt="画像">
    </div>
    <div class="first-row-contena">
      <div class="content-box">
        <p class="content">{{ fields.familyName }}</p>
        <span>FamilyName</span>
      </div>
      <div class="content-box">
        <p class="content">{{ fields.givenName }}</p>
        <span>GivenName</span>
      </div>
    </div>
    <div class="second-row-contena">
      <div class="content-box">
        <p class="content">{{ fields.number }}</p>
        <span>Number</span>
      </div>
      <div class="content-box">
        <p class="content">{{ fields.email }}</p>
        <span>Email</span>
      </div>
    </div>
    <div class="third-row-contena">
      <div class="content-box">
        <p class="content">{{ fields.role }}</p>
        <span>Role</span>
      </div>
      <div class="content-box">
        <p class="content">{{ fields.admin }}</p>
        <span>Admin</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['action_info'],
  data: function(){
    return {
      fields: {},
      actionInfo: this.action_info,
    }
  },
  mounted() {
    this.loadUser();
  },
  methods: {
    loadUser: function() {
      axios.get('/api/user/' + this.actionInfo.id).then(e => {
        this.fields = e.data;
        var name = this.fields.name.split(' ');
        this.fields.familyName = name[0];
        this.fields.givenName = name[1];
      }).catch((error) => {
        console.log(error);
      });
    },
  }
}
</script>