<template>
  <div id="navbar">
  <nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <img src="@/assets/imagenavbar.png" />
    <router-link class="navbar-brand" to="/">RAUD DETECTOR</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div  class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <router-link class="nav-link" v-if="isLoggedIn && isAdmin == true" to="/admin">ADMIN PANEL</router-link>
        </li> 
      </ul>
    </div>

      <form class="d-flex me-2">
        <input v-model="searchData" class="form-control me-1" type="search" placeholder="Search an app" aria-label="Search" style="width: 300px;">
        <!-- <button id="search" class="btn btn-primary" type="submit">Search</button> -->
      </form>
      

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <router-link to="/login" v-if="!isLoggedIn" class="nav-link active" aria-current="page" >Login</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/signup" v-if="!isLoggedIn" class="nav-link active" aria-current="page">Signup</router-link>
        </li>
      </ul>

      
        <ul v-if="isLoggedIn" class="navbar-nav mb-2 mb-lg-0 me-2">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account</a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><router-link class="dropdown-item pb-0" to="/account">My Account</router-link></li>
            <li><hr class="dropdown-divider"></li>
          <button class="dropdown-item logout-button pt-0 pb-0" v-if="isLoggedIn" v-on:click="logout()">Logout</button>  

          </ul>
        </li>
      </ul>
  </div>
</nav>
</div>
  </template>
  
  <script>
import { useMyStore } from '@/store/navbar.js'
import axios from 'axios'
import {toast} from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
  export default {
    
    name: 'NavbarItem',


  computed: {
    isLoggedIn() {
      const userStore = useMyStore();
      return userStore.loginState;
    },

     isAdmin() {
      const userStore = useMyStore();
      return userStore.isAdmin;
    },
    
 searchData: {
    get() {
      const userStore = useMyStore();
      return userStore.searchData;
     
    },
    set(value) {
      const userStore = useMyStore();
      userStore.setSearchData(value);
    }
  },
  },

   watch: {
    searchData(newVal, oldVal) {
      if (newVal !== oldVal) {
        const userStore = useMyStore();
        userStore.getSearchResult();
      } 
    }
  },
  
created()
 {
  let result = localStorage.getItem('user-token');
    if(result) {
      const userStore = useMyStore();
      userStore.setUserInfo();
    }
 },
    methods:{
          logoutToast()
            {
              toast.success('Logout successfull',{
                autoClose:1000,
              });

            },

      async logout()
      { 
            let userToken = localStorage.getItem('user-token');
            userToken = userToken.replace(/^"(.*)"$/, '$1');
            await axios.post("http://127.0.0.1:8000/api/logout",{},
            {
              headers:{
                'Authorization': `Bearer ${userToken}`
              }
            });

      localStorage.clear();
      this.$router.push({name:'Home'});
      const userStore = useMyStore();
      userStore.loginState = false;
      this.logoutToast();
      }

    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
#navbar{
  position: fixed;
    top: 0;
    width: 100%;
    background-color: darkcyan;

}
.logout-button {
    color: red;
}

#search{
  border-color: skyblue;
  background-color: darkcyan;
  color:white;
}

  </style>
  