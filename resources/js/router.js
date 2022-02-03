import Vue from "vue";
import VueRouter from "vue-router";
 
Vue.use(VueRouter);

import index from "./components/item/main/MainComponent.vue";
import create from "./components/item/create/CreatebaseComponent.vue";
import show from "./components/item/show/ShowpageComponent.vue";
import edit from "./components/item/edit/EditbaseComponent.vue";
import login from "./components/auth/AuthComponent.vue";
import admindashboard from "./components/admin/dashboardComponent.vue";
import adminuser from "./components/admin/usersComponent.vue";
import adminitem from "./components/admin/itemsComponent.vue";
import admincart from "./components/admin/cartsComponent.vue";
import adminnotification from "./components/admin/notificationsComponent.vue";
import admintag from "./components/admin/tagsComponent.vue";
import adminthema from "./components/admin/themasComponent.vue";
import adminhistory from "./components/admin/historyComponent.vue";
import cart from "./components/cart/CartComponent.vue";
import cartconfirm from "./components/cart/ConfirmComponent.vue";
import usershow from "./components/user/show/UserComponent.vue";
import useredit from "./components/user/edit/User_editComponent.vue";
import inventory from "./components/share/InventoryComponent.vue";

const router = new VueRouter({
  mode: "history",
  routes: [
    // ブックマークからメインページに飛ぶとき
    {
      path: "/items/top",
      name: "top",
      props: { 'showAnimationFlag': true},
      beforeEnter: (to, from, next) => {
        axios.post('/api/allResetinfo').then(e => {
          next({ name: 'index' })
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/index",
      name: "index",
      component: index,
      props: true,
      beforeEnter: (to, from, next) => {
        if(from.name === 'admindashboard' || from.name === 'adminuser' || from.name === 'adminitem' || from.name === 'admintag' || from.name === 'adminthema' || from.name === 'adminhistory'){
          next();
        }
        if(from.name === 'cartconfirm'){
          axios.post('/api/refreshCart').then(e => {
            next();
          }).catch((error) => {
            console.log(error);
          });
        }
        axios.get('/api/info').then(e => {
          if(e.data.user_id !== null){
            next();
          }else{
            next({ name: 'login', params: {showAnimationFlag: true} })
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/create",
      name: "create",
      component: create,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id !== null){
            next();
          }else{
            next({ name: 'login' })
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/:id/show",
      name: "show",
      component: show,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id !== null){
            next();
          }else{
            next({ name: 'login' })
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/:id/edit",
      name: "edit",
      component: edit,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id !== null){
            next();
          }else{
            next({ name: 'login' })
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/login",
      name: "login",
      component: login,
      props: true,
      beforeEnter: (to, from, next) => {
        if(from.name === 'admindashboard' || from.name === 'adminuser' || from.name === 'adminitem' || from.name === 'admintag' || from.name === 'adminthema'){
          next();
        }
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next();
          }else{
            next({ name: 'index' })
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/cart/index",
      name: "cart",
      component: cart,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next({ name: 'login' });
          }else{
            next();
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/cart/confirm",
      name: "cartconfirm",
      component: cartconfirm,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next({ name: 'login' });
          }else{
            next();
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/user/:id/show",
      name: "usershow",
      component: usershow,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next({ name: 'login' });
          }else{
            next();
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/user/:id/edit",
      name: "useredit",
      component: useredit,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next({ name: 'login' });
          }else{
            next();
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/inventory",
      name: "inventory",
      component: inventory,
      beforeEnter: (to, from, next) => {
        axios.get('/api/info').then(e => {
          if(e.data.user_id === null){
            next({ name: 'login' });
          }else{
            next();
          }
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    {
      path: "/items/dashboard",
      name: "admindashboard",
      component: admindashboard,
      props: true
    },
    {
      path: "/items/adminuser",
      name: "adminuser",
      component: adminuser
    },
    {
      path: "/items/adminitem",
      name: "adminitem",
      component: adminitem
    },
    {
      path: "/items/admincart",
      name: "admincart",
      component: admincart
    },
    {
      path: "/items/adminnotification",
      name: "adminnotification",
      component: adminnotification
    },
    {
      path: "/items/admintag",
      name: "admintag",
      component: admintag
    },
    {
      path: "/items/adminthema",
      name: "adminthema",
      component: adminthema
    },
    {
      path: "/items/adminhistory",
      name: "adminhistory",
      component: adminhistory
    },
  ]
});
 
export default router;

// beforeEnter: (to, from, next) => {
//   axios.get('/api/info').then(e => {
//     if(e.data.user_id === null){
//       next({ name: 'login' });
//     }else{
//       axios.get('/api/checkAdmin').then(e => {
//         if(e.data.admin){
//           next();
//         }else{
//           next({ name: 'index' });
//         }
//       }).catch((error) => {
//         console.log(error);
//       });
//     }
//   }).catch((error) => {
//     console.log(error);
//   });
// }