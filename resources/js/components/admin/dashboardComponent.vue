<template>
  <main class="main-dashboard">

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
      <div class="main-title">Dash Board</div>
      <div class="count-info-contena">
        <div class="count-info count-info-users" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Users</p>
              <p class="info-count">{{ userCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-users icon users-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-items" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Items</p>
              <p class="info-count">{{ itemCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-shopping-bag icon items-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-cart" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Cart</p>
              <p class="info-count">{{ cartCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-shopping-cart icon cart-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-notification" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Notification</p>
              <p class="info-count">{{ notificationCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-bell icon notification-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-tag" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Tags</p>
              <p class="info-count">{{ tagCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-tags icon tag-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-thema" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Themas</p>
              <p class="info-count">{{ themaCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-graduation-cap icon thema-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info count-info-history" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">History</p>
              <p class="info-count">{{ historyCount }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-history icon history-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info size-info-user" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">User Image</p>
              <p class="info-count info-size">{{ userImageSize }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-portrait icon user-image-icon fa-3x"></i>
            </div>
          </div>
        </div>
        <div class="count-info size-info-item" v-bind:class="{show: loadCompFlag}">
          <div class="count-info-main">
            <div class="left-count-info">
              <p class="info-name">Item Image</p>
              <p class="info-count info-size">{{ itemImageSize }}</p>
            </div>
            <div class="right-count-info">
              <i class="fas fa-image icon item-image-icon fa-3x"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-globe submain-contena-icon globe-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Hello AdminUser</p>
          
          <div class="submain-content">
            <div class="action-box">
              <div class="lottie">
                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_8hddy41z.json"  background="transparent"  speed="0.5"  style="width: 350px; height: 350px;" loop  autoplay class="lottie-content"></lottie-player>
              </div>
              <div class="explane-contena">
                <h1>Admin Pass Change</h1>
                <div class="explane">
                  <p>管理者用パスワードの変更をすることができます.</p>
                  <p>パスワードの変更後は管理室側で保存してください.</p>
                </div>
                <a href="#" class="action-link" @click.prevent.stop="linkAction('admin-pass', null)">Start</a>
              </div>
            </div>
            <div class="action-box">
              <div class="lottie">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_vo0a1yca.json"  background="transparent"  speed="0.5"  style="width: 350px; height: 350px;" loop  autoplay class="lottie-content"></lottie-player>
              </div>
              <div class="explane-contena">
                <h1>Refresh Table</h1>
                <div class="explane">
                  <p>データベースからデータを一括削除することができます.</p>
                  <p>一括削除が可能な項目は、製品データと通知データ, 履歴データの3つとなっています.</p>
                  <p>製品データを削除した場合、関連する画像ファイルやタグ情報、カート情報も削除されます.</p>
                  <p>削除したい項目のボタンを押して削除ボタンを押してください.</p>
                </div>
                <a href="#" class="action-link" @click.prevent.stop="linkAction('table-refresh', null)">Start</a>
              </div>
            </div>
            <div class="action-box">
              <div class="lottie">
                <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_kv7kbdzp.json"  background="transparent"  speed="0.5"  style="width: 350px; height: 350px;" loop  autoplay class="lottie-content"></lottie-player>
              </div>
              <div class="explane-contena">
                <h1>Items Backup</h1>
                <p class="explane">製品一覧をExcelにエクスポートしてデータのバックアップを取ることができます.</p>
                <a href="/backup/export_view" class="action-link" download="">Export</a>
              </div>
            </div>
            <div class="action-box">
              <div class="lottie">
                <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_ctqgzmyh.json"  background="transparent"  speed="0.5"  style="width: 350px; height: 350px;"  loop  autoplay class="lottie-content"></lottie-player>
              </div>
              <div class="explane-contena">
                <h1>Items Import</h1>
                <p class="explane">製品データをExcelからインポートし、データベースに一括挿入することができます.</p>
                <a href="#" class="action-link" @click.prevent.stop="linkAction('import-data', null)">Start</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  props: ['showAnimationFlag'],
  data: function() {
    return {
      userCount: 0,
      itemCount: 0,
      cartCount: 0,
      notificationCount: 0,
      tagCount: 0,
      themaCount: 0,
      historyCount: 0,
      userImageSize: '',
      itemImageSize: '',
      loadCompFlag: false,
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
      file: null,
    }
  },
  mounted() {
    if(this.showAnimationFlag !== undefined){
      this.$emit('class-event', 'admin', true);
    }else {
      this.$emit('class-event', 'admin');
    }
    this.loadCount();
  },
  methods: {
    loadCount: function() {
      this.loadCompFlag = false;
      axios.get('/api/countInfo').then(e => {
        this.userCount = e.data.user_count;
        this.itemCount = e.data.item_count;
        this.cartCount = e.data.cart_count;
        this.notificationCount = e.data.notification_count;
        this.tagCount = e.data.tag_count;
        this.themaCount = e.data.thema_count;
        this.historyCount = e.data.history_count;
        this.userImageSize = e.data.userImage_size;
        this.itemImageSize = e.data.itemImage_size;
        this.loadCompFlag = true;
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
    refreshAction: function() {
      this.loadCount();
    },
    closeMethod: function() {
      this.showFlag = false;
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
      }, 500);
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    },
  }
}
</script>