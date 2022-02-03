<template>
  <main id="main" class="main">
    <subheader-component
      v-on:subheader-event="subheaderAction"
    ></subheader-component>
    <p class="main_products_title">Items</p>
    <div class="page_of_main">
      <asidenav-component
        v-on:linkclick-event="linkclickAction"
      ></asidenav-component>
      <article class="main_products">
        <div class="name_with_search_bar">
          <div class="item_category_name">
            <p>All Items
              <span v-show="fields.first_category" class="category_span_first">{{ fields.first_category }}</span>
              <span v-show="fields.second_category"> &nbsp;>&nbsp; {{ fields.second_category }}</span>
              <span v-show="fields.third_category"> &nbsp;>&nbsp; {{ fields.third_category }}</span>
            </p>
          </div>
          <div class="search_bar">
            <form class="search_bar_form">
              <input type="search" name="search" placeholder="Search..." class="search_text" autocomplete="off" v-model="keyword">
              <button type="button" @click.prevent.stop="searchAction" class="search_decision"><i class="fas fa-search"></i></button>
            </form>
          </div>
        </div>
        <div class="select_item_amount_all">
          <p class="item_amount_dsp">表示件数&nbsp;{{ fields.fromPage }}～{{ fields.toPage }}件&nbsp;({{ fields.totalAmount }}件中)</p>
          <div class="select_item_amount_div_all">
            <p>表示件数</p>
            <form action="index.html" method="post">
              <div class="select_item_amount_div">
                <p class="select_item_amount_p" id="select_item_amount_p">
                  <span class="select_item_amount_p_span" id="select_item_amount_p_span">{{ fields.perpage }}</span>件
                  &emsp;<i class="fas fa-angle-down"></i>
                </p>
                <ul class="select_menu" id="select_menu">
                  <li class="select_item_amount_number selected" @click="perpage10"><span id="perpage_10" class="number">10</span>件</li>
                  <li class="select_item_amount_number" @click="perpage15"><span id="perpage_15" class="number">15</span>件</li>
                  <li class="select_item_amount_number" @click="perpage20"><span id="perpage_20" class="number">20</span>件</li>
                </ul>
              </div>
            </form>
          </div>
        </div>
        <ul class="select_items">
          <!-- サブローディング -->
          <div class="sub-loader" v-bind:class="{subloadingHide: isHide}">
            <div class="sub-loading"></div>
          </div>
          <div class="no-items" v-show="noItems"><i class="fas fa-info-circle info-icon"></i> 該当する商品はありません.</div>
          <li v-for="(item, index) in items" :key="item.id">
            <div class="for_table_image">
              <a href="#" @click.prevent.stop="showpageLink(item.id)" v-if="linkName === 'purchase'">
                <img :src="item.img_path" alt="No Image">
              </a>
              <img :src="item.img_path" alt="No Image" v-else>
            </div>
            <div class="products_title_tag">
              <div class="products_title">
                <a href="#" @click.prevent.stop="showpageLink(item.id)" v-if="linkName === 'purchase'">{{ item.name }}</a>
                <a href="#" v-else>{{ item.name }}</a>
              </div>
              <div class="products_model_number">{{ item.model }}</div>
              <div class="products_discription">{{ item.comment }}</div>
              <div class="products_tag_all">
                <div class="products_tag">
                  <div class="tag_per" id="tag_per_0" v-for="(tag, index) in item.tags" :key="index">
                    <a href="#" @click.prevent.stop="tagclickAction(tag.tag_name)"><p class="submit_tag">#&thinsp;{{ tag.tag_name }}</p></a>
                  </div>
                </div>
              </div>
            </div>
            <form class="price_number_form">
              <div class="products_price" v-show="linkName === 'purchase'">
                <p>&yen;{{ Number(item.price).toLocaleString() }}</p>
              </div>
              <div class="products_amount" v-show="linkName === 'inventory'">
                <div class="products_amount_div">
                  <p>在庫数量</p>
                  <p class="amount_num">{{ item.stocks }}</p>
                </div>
              </div>
              <quantity-component v-if="linkName === 'purchase' && item.cart === null"
                key="first_key"
                :index="index"
                :defaultQuantity=0
                :linkname="linkName"
                ref="quantityreset"
                v-on:quantity-event="quantityMethod"
              ></quantity-component>
              <quantity-component v-else-if="linkName === 'inventory'"
                key="second_key"
                :index="index"
                :defaultQuantity=0
                :linkname="linkName"
                ref="quantityreset"
                v-on:quantity-event="quantityMethod"
              ></quantity-component>
              <quantity-component v-else-if="linkName === 'purchase' && item.cart !== null"
                key="third_key"
                :index="index"
                :defaultQuantity="item.cart.quantity"
                :linkname="linkName"
                ref="quantityreset"
                v-on:quantity-event="quantityMethod"
              ></quantity-component>
              <add-component
                :item="item"
                :index="index"
                :flg="item.bool"
                ref="quantity"
                v-on:cartchange-event="cartchangeMethod"
                v-on:quantityreset-event="quantityresetMethod"
                v-on:messageshow-event="messageshowMethod"
                v-if="linkName === 'purchase'"
              ></add-component>
              <inventory-component
                :id="item.id"
                :index="index"
                :itemName="item.name"
                ref="stocks"
                v-if="linkName === 'inventory'"
                v-on:submit-event="inventorySubmitAction"
                v-on:quantityreset-event="quantityresetMethod"
                v-on:messageshow-event="messageshowMethod"
                v-on:notificationChange-event="notificationChangeMethod" 
              ></inventory-component>
            </form>
          </li>
        </ul>
        <div class="for_pagenation_div">
          <ul v-if="caseType === '1'" class="for_pagenation_ul">
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.fromPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 1)"><i class="fas fa-chevron-left"></i></a></li>
            <li v-for="page of fields.maxPage" :key="page" class="for_pagenation_li" v-bind:class="{ for_pagenation_li_selected: fields.currentPage === page }">
              <a href="#" @click.prevent.stop="paginateAction(page)">{{ page }}</a>
            </li>
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.maxPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 1)"><i class="fas fa-chevron-right"></i></a></li>
          </ul>
          <ul v-else-if="this.caseType === '2'" class="for_pagenation_ul">
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.fromPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 1)"><i class="fas fa-chevron-left"></i></a></li>
            <li v-for="page in 7" :key="page" class="for_pagenation_li" v-bind:class="{ for_pagenation_li_selected: fields.currentPage === page }">
              <a href="#" @click.prevent.stop="paginateAction(page)">{{ page }}</a>
            </li>
            <li class="for_pagenation_li_gap">…</li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.maxPage)">{{ fields.maxPage }}</a></li>
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.maxPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 1)"><i class="fas fa-chevron-right"></i></a></li>
          </ul>
          <ul v-else-if="this.caseType === '3'" class="for_pagenation_ul">
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.fromPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 1)"><i class="fas fa-chevron-left"></i></a></li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(1)">1</a></li>
            <li class="for_pagenation_li_gap">…</li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 2)">{{ fields.currentPage - 2 }}</a></li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 1)">{{ fields.currentPage - 1 }}</a></li>
            <li class="for_pagenation_li for_pagenation_li_selected"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage)">{{ fields.currentPage }}</a></li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 1)">{{ fields.currentPage + 1 }}</a></li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 2)">{{ fields.currentPage + 2 }}</a></li>
            <li class="for_pagenation_li_gap">…</li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(fields.maxPage)">{{ fields.maxPage }}</a></li>
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.maxPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 1)"><i class="fas fa-chevron-right"></i></a></li>
          </ul>
          <ul v-else-if="this.caseType === '4'" class="for_pagenation_ul">
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.fromPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage - 1)"><i class="fas fa-chevron-left"></i></a></li>
            <li class="for_pagenation_li"><a href="#" @click.prevent.stop="paginateAction(1)">1</a></li>
            <li class="for_pagenation_li_gap">…</li>
            <li v-for="page in 7" :key="page" class="for_pagenation_li" v-bind:class="{ for_pagenation_li_selected: fields.currentPage === fields.maxPage - 7 + page }">
              <a href="#" @click.prevent.stop="paginateAction(fields.maxPage - 7 + page)">{{ fields.maxPage - 7 + page }}</a>
            </li>
            <li class="for_pagenation_li" v-show="fields.currentPage !== fields.maxPage"><a href="#" @click.prevent.stop="paginateAction(fields.currentPage + 1)"><i class="fas fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </article>
    </div>
    <div class="for_pagetop">
      <p class="for_pagetop_icon">
        <a href="#"><i class="fas fa-angle-up"></i></a>
      </p>
      <p><a href="#">PAGE TOP</a></p>
    </div>
    <div class="for_new_item_making">
      <a href="#" @click.prevent.stop="createpageLink">
        <div class="for_item_making_div">
          <img src="/image/new_item_icon.png" alt="creativity" class="create_item_icon">
        </div>
      </a>
    </div>
  </main>
</template>

<script>
export default {
  props: ['firstAccess', 'authFlag'],
  data: function(){
    return {
      keyword: '',
      items: [],
      fields: {},
      subIshidden: false,
      noItems: false,
      linkName: '',
      isHide: true,
      caseType: '1',
    }
  },
  mounted() {
    this.loadInfo();
    $(function(){
      $(document).on('click',function(e) {
        if(!$(e.target).closest('#select_item_amount_p').length) {
          $('#select_menu').slideUp(300);
        }
      });
      $('#select_item_amount_p').click(function(){
        $('#select_menu').slideToggle(300);
      });
      $('.select_item_amount_number').on('click',function(event) {
        $('.select_item_amount_number').removeClass("selected");
        $(this).addClass("selected");
        var str = $(this).text();
        var str_num = str.substr(0, 2);
        $('#select_item_amount_p_span').text(str_num);
      });
    });
  },
  methods: {
    perpage10: function(){
      var perpage = document.getElementById("perpage_10").textContent;
      this.fields.perpage = perpage;
      this.perpageClick();
    },
    perpage15: function(){
      var perpage = document.getElementById("perpage_15").textContent;
      this.fields.perpage = perpage;
      this.perpageClick();
    },
    perpage20: function(){
      var perpage = document.getElementById("perpage_20").textContent;
      this.fields.perpage = perpage;
      this.perpageClick();
    },
    loadItems: function() {
      axios.get('/api/item?page=' + this.fields.currentPage, {
        params: {
          perpage: this.fields.perpage,
          first_category: this.fields.first_category,
          second_category: this.fields.second_category,
          third_category: this.fields.third_category,
          first_search: this.fields.first_search,
          second_search: this.fields.second_search,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.caseCheckAction(this.fields.currentPage, e.data.meta.last_page);
        this.$emit('loading-event', false);
        if(this.authFlag !== undefined){
          this.$emit('message-event', 'ログインしました.', true);
        }
      }).catch((error) => {
        console.log(error);
      });
    },
    loadInfo: function() {
      this.$emit('loading-event', true);
      axios.get('/api/info').then(e => {
        this.fields.perpage = e.data.perpage;
        this.fields.currentPage = e.data.currentPage;
        this.fields.first_category = e.data.first_category;
        this.fields.second_category = e.data.second_category;
        this.fields.third_category = e.data.third_category;
        this.fields.first_search = e.data.first_search;
        this.fields.second_search = e.data.second_search;
        this.linkName = e.data.link_name;
        if(this.linkName === 'inventory'){
          this.$emit('class-event', 'inventory');
        }else{
          this.$emit('class-event', 'main');
        }
        this.keyword = e.data.second_search;
        this.$emit('cartReset-event');
        this.loadItems();
      }).catch((error) => {
        console.log(error);
      });
    },
    createpageLink: function() {
      this.$emit('loading-event', true);
      setTimeout(() => {
        this.$router.push({
          name: 'create'
        })
      }, 700);
    },
    showpageLink: function(id) {
      this.$emit('loading-event', true);
      setTimeout(() => {
        this.$router.push({
          name: 'show',
          params: {
            id: id
          }
        })
      }, 500);
    },
    searchAction: function() {
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_category: this.fields.first_category,
          second_category: this.fields.second_category,
          third_category: this.fields.third_category,
          first_search: this.fields.first_search,
          second_search: this.keyword,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.fields.second_search = this.keyword;
        this.caseCheckAction(1, e.data.meta.last_page);
        setTimeout(() => {
          this.isHide = true;
        }, 500);
      }).catch((error) => {
        console.log(error);
      });
    },
    tagclickAction: function(tag) {
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_category: '#' + tag,
          second_category: null,
          third_category: null,
          first_search: tag,
          second_search: null,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.fields.currentPage = 1;
        this.items = e.data.data;
        this.fields.first_category = '#' + tag;
        this.fields.second_category = null;
        this.fields.third_category = null;
        this.keyword = '';
        this.caseCheckAction(1, e.data.meta.last_page);
        setTimeout(() => {
          this.isHide = true;
        }, 500);
      }).catch((error) => {
        console.log(error);
      });
    },
    linkclickAction: function(first_category, second_category, third_category){
      this.isHide = false;
      let searching = null;
      if(second_category === null){
        searching = first_category;
      }else if(second_category !== null && third_category === null){
        searching = second_category;
      }else{
        searching = third_category;
      }
      axios.get('/api/item?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_category: first_category,
          second_category: second_category,
          third_category: third_category,
          first_search: searching,
          second_search: null,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.items = e.data.data;
        this.fields.first_category = first_category;
        this.fields.second_category = second_category;
        this.fields.third_category = third_category;
        this.fields.first_search = searching;
        this.keyword = '';
        this.caseCheckAction(1, e.data.meta.last_page);
        setTimeout(() => {
          this.isHide = true;
        }, 500);
      }).catch((error) => {
        console.log(error);
      });
    },
    paginateAction: function(page){
      this.isHide = false; 
      axios.get('/api/item?page=' + page, {
        params: {
          perpage: this.fields.perpage,
          first_category: this.fields.first_category,
          second_category: this.fields.second_category,
          third_category: this.fields.third_category,
          first_search: this.fields.first_search,
          second_search: this.fields.second_search,
        }
      }).then(e => {
        this.fields.currentPage = page;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.items = e.data.data;
        this.caseCheckAction(page, e.data.meta.last_page);
        setTimeout(() => {
          this.isHide = true;
        }, 500);
      }).catch((error) => {
        console.log(error);
      });
    },
    perpageClick: function(){
      this.isHide = false;
      axios.get('/api/item?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_category: this.fields.first_category,
          second_category: this.fields.second_category,
          third_category: this.fields.third_category,
          first_search: this.fields.first_search,
          second_search: this.fields.second_search,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.items = e.data.data;
        setTimeout(() => {
          this.isHide = true;
        }, 500);
      }).catch((error) => {
        console.log(error);
      });
    },
    quantityMethod: function(count, index, linkname){
      if(linkname === 'purchase'){
        this.$refs.quantity[index].changequantityMethod(count);
      }else{
        this.$refs.stocks[index].changequantityMethod(count);
      }
    },
    cartchangeMethod: function(){
      this.$emit('cartchange-event');
    },
    messageshowMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    },
    quantityresetMethod: function(index) {
      this.$refs.quantityreset[index].quantityresetMethod();
    },
    subheaderAction: function(linkName) {
      let formData = new FormData();
      formData.append('link_name', linkName);

      axios.post('/api/resetInfo', formData).then(e => {
        if(linkName === 'purchase'){
          this.$emit('class-event', 'main');
        }else{
          this.$emit('class-event', 'inventory');
        }
        this.loadInfo();
      }).catch((error) => {
        console.log(error);
      });
    },
    inventorySubmitAction: function(index, stocks, bool) {
      if(bool){
        this.items[index].stocks += stocks;
      }else{
        this.items[index].stocks -= stocks;
      }
    },
    notificationChangeMethod: function() {
      this.$emit('notificationChange-event');
    },
    caseCheckAction: function(currentPage, maxPage){
      if(maxPage <= 9){
        this.caseType = '1';
      }else{
        if(currentPage <= 5){
          this.caseType = '2';
        }else if(5 < currentPage && currentPage <= maxPage - 5){
          this.caseType = '3';
        }else if(maxPage - 5 < currentPage && currentPage <= maxPage){
          this.caseType = '4';
        }
      }
      console.log(this.caseType);
    }
  }
}
</script>