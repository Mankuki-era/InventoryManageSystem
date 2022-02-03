<template>
  <main class="main-user">

    <div class="modal-window" v-bind:class="{show: showFlag, none: noneFlag, hide: hideFlag}">
      <adminmodal-component
        v-on:close-event="closeMethod"
        v-on:refresh-event="refreshAction"
        v-on:message-event="messageMethod"
        ref="modalchild"
      ></adminmodal-component>
    </div>
    <div class="modal-mask" v-bind:class="{none: noneFlag}"></div>

    <div class="main-contena">
      <div class="main-title">User Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-user submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Users Table</p>
          <div class="buttons">
            <li class="add-button"><a href="#" @click.prevent.stop="linkAction('user-create', null)"><i class="fas fa-plus buttons-icon add-icon"></i>ADD NEW</a></li>
            <li class="refresh-button"><a href="#" @click.prevent.stop="refreshAction"><i class="fas fa-redo-alt buttons-icon refresh-icon"></i>REFRESH</a></li>
          </div>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>名前</th>
                <th>職番</th>
                <th>Email</th>
                <th>プロフィール画像パス</th>
                <th>所属</th>
                <th>権限</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.number }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.img_path }}</td>
                <td v-if="user.role === 'DAYTIME'">昼勤</td>
                <td v-else-if="user.role === 'NIGHTTIME'">夜勤</td>
                <td v-else-if="user.role === 'TEACHER'">先生</td>
                <td v-if="user.admin === 'assignment'">管理者</td>
                <td v-else-if="user.admin === 'nonassignment'">一般</td>
                <td>
                  <a href="#" @click.prevent.stop="linkAction('user-show', user.id)"><i class="fas fa-eye action-icon show-icon"></i></a>
                  <a href="#" @click.prevent.stop="linkAction('user-edit', user.id)"><i class="fas fa-pen action-icon edit-icon"></i></a>
                  <a href="#" @click.prevent.stop="linkAction('user-destroy', user.id)"><i class="fas fa-trash-alt action-icon trash-icon"></i></a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      users: {},
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.loadUsers();
  },
  methods: {
    loadUsers: function(){
      this.$emit("adminLoading-event", true);
      axios.get('/api/user').then(e => {
        this.users = e.data;
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    linkAction: function(actionName, id) {
      this.$refs.modalchild.initFields(actionName, id);
      this.hideFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 100);
    },
    closeMethod: function() {
      this.showFlag = false;
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
      }, 500);
    },
    refreshAction: function() {
      this.loadUsers();
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    }
  }
}
</script>