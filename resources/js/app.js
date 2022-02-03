/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import router from "./router";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('root-component', require('./components/RootComponent.vue').default);

//admin---------------------------------------------------------------------------------------------------------------------------------
Vue.component('admindashboard-component', require('./components/admin/dashboardComponent.vue').default);
Vue.component('adminuser-component', require('./components/admin/usersComponent.vue').default);
Vue.component('adminitem-component', require('./components/admin/itemsComponent.vue').default);
Vue.component('admincart-component', require('./components/admin/cartsComponent.vue').default);
Vue.component('adminnotification-component', require('./components/admin/notificationsComponent.vue').default);
Vue.component('admintag-component', require('./components/admin/tagsComponent.vue').default);
Vue.component('adminthema-component', require('./components/admin/themasComponent.vue').default);
Vue.component('adminmodal-component', require('./components/admin/modalComponent.vue').default);
Vue.component('adminhistory-component', require('./components/admin/historyComponent.vue').default);

//modal----------------------------------------------------------------------------------------------------------------------------------
Vue.component('itemCreateEditModal-component', require('./components/modal/itemCreateEditComponent.vue').default);
Vue.component('itemShowModal-component', require('./components/modal/itemShowComponent.vue').default);
Vue.component('userCreateEditModal-component', require('./components/modal/userCreateEditComponent.vue').default);
Vue.component('userShowModal-component', require('./components/modal/userShowComponent.vue').default);
Vue.component('themaCreateEditModal-component', require('./components/modal/themaCreateEditComponent.vue').default);
Vue.component('destroy-component', require('./components/modal/destroyComponent.vue').default);
Vue.component('adminPassChange-component', require('./components/modal/adminPassChangeComponent.vue').default);
Vue.component('tableRefresh-component', require('./components/modal/tableRefreshComponent.vue').default);
Vue.component('importData-component', require('./components/modal/importDataComponent.vue').default);
Vue.component('cartModal-component', require('./components/modal/cartModalComponent.vue').default);

//share----------------------------------------------------------------------------------------------------------------------------------
Vue.component('alert-component', require('./components/share/AlertComponent.vue').default);
Vue.component('header-component', require('./components/share/HeaderComponent.vue').default);
Vue.component('footer-component', require('./components/share/FooterComponent.vue').default);
Vue.component('adminheader-component', require('./components/share/AdminheaderComponent.vue').default);
Vue.component('add-component', require('./components/share/AddComponent.vue').default);
Vue.component('quantity-component', require('./components/share/QuantityComponent.vue').default);
Vue.component('loading-component', require('./components/share/LoadingComponent.vue').default);
Vue.component('message-component', require('./components/share/MessageComponent.vue').default);
Vue.component('inventory-component', require('./components/share/InventoryComponent.vue').default);
Vue.component('adminLoading-component', require('./components/share/AdminLoadingComponent.vue').default);

//item-----------------------------------------------------------------------------------------------------------------------------------
//main
Vue.component('main-component', require('./components/item/main/MainComponent.vue').default);
Vue.component('subheader-component', require('./components/item/main/SubheaderComponent.vue').default);
Vue.component('asidenav-component', require('./components/item/main/AsidenavComponent.vue').default);

//create
Vue.component('createbase-component', require('./components/item/create/CreatebaseComponent.vue').default);
Vue.component('createpage-component', require('./components/item/create/CreatepageComponent.vue').default);
Vue.component('createconfirmPage-component', require('./components/item/create/CreateconfirmpageComponent.vue').default);

//edit
Vue.component('editbase-component', require('./components/item/edit/EditbaseComponent.vue').default);
Vue.component('editpage-component', require('./components/item/edit/EditpageComponent.vue').default);
Vue.component('editconfirmPage-component', require('./components/item/edit/EditconfirmpageComponent.vue').default);

//show
Vue.component('showpage-component', require('./components/item/show/ShowpageComponent.vue').default);

//auth------------------------------------------------------------------------------------------------------------------------------------
Vue.component('auth-component', require('./components/auth/AuthComponent.vue').default);
Vue.component('login-component', require('./components/auth/LoginComponent.vue').default);
Vue.component('register-component', require('./components/auth/RegisterComponent.vue').default);

//user------------------------------------------------------------------------------------------------------------------------------------
Vue.component('user-component', require('./components/user/show/UserComponent.vue').default);
Vue.component('useredit-component', require('./components/user/edit/User_editComponent.vue').default);

//cart------------------------------------------------------------------------------------------------------------------------------------
Vue.component('cart-component', require('./components/cart/CartComponent.vue').default);
Vue.component('confirm-component', require('./components/cart/ConfirmComponent.vue').default);

const app = new Vue({
    el: '#app',
    router: router,
});
