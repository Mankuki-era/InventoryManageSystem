<template>
  <main class="main-item">

    <div class="modal-window" v-bind:class="{show: showFlag, none: noneFlag, hide: hideFlag}">
      <adminmodal-component
        v-on:close-event="closeMethod"
        v-on:refresh-event="refreshAction"
        v-on:message-event="messageMethod"
        v-on:cartchange-event="cartChangeMethod"
        v-on:stocksChange-event="stocksChangeMethod"
        ref="modalchild"
      ></adminmodal-component>
    </div>
    <div class="modal-mask" v-bind:class="{none: noneFlag}"></div>

    <div class="main-contena">
      <div class="main-title">Item Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-clipboard-list submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Items Table</p>
          <div class="buttons">
            <li class="add-button"><a href="#" @click.prevent.stop="linkAction('item-create', null)"><i class="fas fa-plus buttons-icon add-icon"></i>ADD NEW</a></li>
            <li class="refresh-button"><a href="#" @click.prevent.stop="refreshAction"><i class="fas fa-redo-alt buttons-icon refresh-icon"></i>REFRESH</a></li>
            <li class="favoriteOff-button" v-if="fields.favorite"><a href="#" @click.prevent.stop="favoriteFilterOffAction"><i class="fas fa-star buttons-icon favoriteOff-icon star-icon"></i>FAVORITE</a></li>
            <li class="favoriteOn-button" v-else><a href="#" @click.prevent.stop="favoriteFilterOnAction"><i class="fas fa-star buttons-icon favoriteOn-icon star-icon"></i>FAVORITE</a></li>
          </div>
          <div class="form-contena">
            <div class="perpage-select-box">
              <select class="perpage_selection" v-model="fields.perpage" @change="perpageClick" required>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
              </select>
              <div class="underline"></div>
              <label for="">Perpage</label>
            </div>
            <div class="search-box">
              <input type="text" v-model="fields.second_search" required>
              <div class="underline"></div>
              <label for="">Search</label>
              <a href="#" class="search-button" @click.prevent.stop="searchAction"><i class="fas fa-search search-icon"></i></a>
            </div>
          </div>
          <div class="no-items" v-if="items.length === 0">
            <p><i class="fas fa-info-circle info-icon"></i>製品データがありません.</p>
          </div>
          <table v-if="items.length !== 0">
            <div class="admin-loader" v-bind:class="{ hidden: isHide }"></div>
            <div class="admin-mask" v-bind:class="{ hidden: isHide }"></div>
            <thead>
              <tr>
                <th class="fixed"></th>
                <th class="id">ID</th>
                <th>製品名</th>
                <th>在庫数</th>
                <th>必要数</th>
                <th>型番</th>
                <th>URL</th>
                <th>価格</th>
                <th class="tag">タグ</th>
                <th>備考</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id" v-bind:class="{ cartIn: item.bool}">
                <td class="fixed">
                  <a v-if="item.favorite" @click.prevent.stop="unfavoriteAction(item.id)" class="favoriteIcon-box"><i class="fas fa-star action-icon starOn-icon"></i></a>
                  <a v-else @click.prevent.stop="favoriteAction(item.id)" class="favoriteIcon-box"><i class="far fa-star action-icon starOff-icon"></i></a>
                </td>
                <td class="id">{{ item.id }}</td>
                <td class="name">
                  <div class="buttonPanel" v-bind:class="{ hide: !item.btnshow }">
                    <a href="#" @click.prevent.stop="linkAction('item-show', item.id)"><i class="fas fa-eye action-icon show-icon"></i></a>
                    <a href="#" @click.prevent.stop="linkAction('item-edit', item.id)"><i class="fas fa-pen action-icon edit-icon"></i></a>
                    <a href="#" @click.prevent.stop="linkAction('item-destroy', item.id)"><i class="fas fa-trash-alt action-icon trash-icon"></i></a>
                    <a href="#" @click.prevent.stop="cartInAction(item)" class="cartIcon-box">
                      <i class="fas fa-cart-arrow-down action-icon cart-icon" v-bind:class="{cartIn: item.bool}"></i>
                      <span class="cart-count" v-if="item.bool">{{ item.quantity }}</span>
                    </a>
                    <a href="#" @click.prevent.stop="stocksChangeAction(item)" class="stocksIcon-box"><i class="fas fa-plus-circle action-icon plus-icon"></i><i class="fas fa-minus-circle action-icon minus-icon"></i></a>
                  </div>
                  <a href="#" @click.prevent.stop="nameSelected(item.id)">{{ item.name }}</a>
                </td>
                <td>{{ item.stocks }}{{ item.unit }}</td>
                <td v-if="item.needs_all">通年：{{ item.needs_all }}{{ item.unit }}</td>
                <td v-else-if="item.needs_pro && item.needs_late">前期：{{ item.needs_pro }}{{ item.unit }}, 後期：{{ item.needs_late }}{{ item.unit }}</td>
                <td v-else-if="item.needs_pro">前期：{{ item.needs_pro }}{{ item.unit }}, 後期：0{{ item.unit }}</td>
                <td v-else-if="item.needs_late">前期：0{{ item.unit }}, 後期：{{ item.needs_late }}{{ item.unit }}</td>
                <td v-else></td>
                <td>{{ item.model }}</td>
                <td><a :href="item.url">{{ item.url }}</a></td>
                <td>￥{{ item.price }}</td>
                <td>
                  <span v-for="(tag, index) in item.tags" :key="index" class="tag">
                    {{tag.tag_name}},
                  </span>
                </td>
                <td class="comment">{{ item.comment }}</td>
              </tr>
            </tbody>
          </table>
          <ul class="paginate-box" v-if="items.length !== 0">
            <li class="paginate-link" v-for="page of fields.maxPage" :key="page" v-bind:class="{ this: fields.currentPage === page }">
              <a href="#" @click.prevent.stop="paginateAction(page)">{{ page }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      fields: {},
      // keyword: '',
      noItems: false,
      items: {},
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
      isHide: true,
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.resetInfo();
  },
  methods: {
    resetInfo: function(){
      this.$emit("adminLoading-event", true);
      axios.post('/api/resetInfo').then(e => {
        this.loadInfo();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadInfo: function() {
      axios.get('/api/info').then(e => {
        this.fields = e.data;
        this.loadItems();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadItems: function() {
      axios.get('/api/item?page=' + this.fields.currentPage).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.items.forEach(item => {
          if(item.bool) {
            item.quantity = item.cart.quantity;
          }
        });
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    searchAction: function() {
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          second_search: this.fields.second_search,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    paginateAction: function(page){
      axios.get('/api/item?page=' + page).then(e => {
        this.fields.currentPage = page;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.items = e.data.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    perpageClick: function(){
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          perpage: this.fields.perpage,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.items = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    nameSelected: function(id) {
      this.items.forEach(item => {
        if(item.id === id) {
          item.btnshow = !item.btnshow;
        }else{
          item.btnshow = false;
        }
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
    cartInAction: function(item) {
      if(item.bool === false) {
        this.$refs.modalchild.initFields('cart-in', item.id);
        this.$refs.modalchild.itemSet(item);
        this.hideFlag = false;
        this.noneFlag = false;
        setTimeout(() => {
          this.showFlag = true;
        }, 100);
      }else{
        axios.get('/api/uncart', {
          params: {
            'id': item.id,
          }
        }).then(e => {
          this.items.forEach(itemInfo => {
            if(itemInfo.id === item.id) {
              itemInfo.bool = false;
            }
          });
          this.$emit('message-event', 'カートから出しました.', true);
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    stocksChangeAction: function(item) {
      this.$refs.modalchild.initFields('stocks-change', item.id);
      this.$refs.modalchild.itemSet(item);
      this.hideFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 100);
    },
    favoriteAction: function(id) {
      axios.get('/api/favorite', {
        params: {
          'id': id,
        }
      }).then(e => {
        this.items.forEach((item) => {
          if(item.id === id) {
            item.favorite = true;
          }
        });
      }).catch((error) => {
        console.log(error);
      });
    },
    unfavoriteAction: function(id) {
      axios.get('/api/unfavorite', {
        params: {
          'id': id,
        }
      }).then(e => {
        this.items.forEach((item, index) => {
          if(item.id === id) {
            if(this.fields.favorite === true){
              this.items.splice(index, 1);
            }else{
              item.favorite = false;
            }
          }
        });
      }).catch((error) => {
        console.log(error);
      });
    },
    cartChangeMethod: function(id, quantity) {
      this.items.forEach(item => {
        if(item.id === id) {
          item.bool = true;
          item.quantity = quantity;
        }
      });
    },
    stocksChangeMethod: function(id, quantity, bool) {
      console.log(bool);
      this.items.forEach(item => {
        if(item.id === id) {
          if(bool === 'true') {
            item.stocks += quantity;
          }else{
            item.stocks -= quantity;
          }
        }
      });
    },
    refreshAction: function() {
      this.resetInfo();
    },
    favoriteFilterOnAction: function() {
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          favorite: true,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.favorite = true;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    favoriteFilterOffAction: function() {
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          favorite: false,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.favorite = false;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
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
    }
  }
}
</script>