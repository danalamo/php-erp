import Vue from "vue"
import VueRouter, { } from 'vue-router'
import { Api, formatLocation, route, vueRoute } from "../../assets/data_helpers";
import UserList from "./UserList";
import UserAddEdit from "./UserAddEdit";

Vue.use(VueRouter)

const User = { template: `<h1>test</h1>` }
const props = () => ({ store: window.app && window.app.store || {} })

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: route('vue').index,   component: UserList, props },
    { path: route('vue').userAdd, component: UserAddEdit, props },
    { path: route('vue').userEdit(':user_id'), component: UserAddEdit, props },
  ],
})

window.app = new Vue({
  el: '#vue-app',
  router,
  data: () => ({
    title: 'ERP',
    store: {},
  }),
  computed: {},
  render() {
    const data = this.store
    
    return (
      <div class="container" id="vue-app">
        <div class="menu-links">
          {/*<a href={route('vue').index}>HOME</a> |*/}
          <router-link to={route('vue').index}>
            HOME
          </router-link> |
          <span>
            Employees:
            <router-link to={route('vue').userAdd}>ADD</router-link>
          </span>
        </div>
        <div class="center">
          <svg width="45px" viewBox="0 0 500 500">
            <polygon points="0 0, 100 0, 250 300, 400 0, 500 0, 250 500" fill="#41B883"></polygon>
            <polygon points="100 0, 200 0, 250 100, 300 0, 400 0, 250 300" fill="#35495E"></polygon>
          </svg>
        </div>
        <h1 class="page-title">{data.page_title}</h1>
        <div class="page-body">
          <router-view></router-view>
        </div>
      </div>
    );
  }
})
