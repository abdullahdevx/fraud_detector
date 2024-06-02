<template>
    <div class="register">
     <br><br>
     <h1 id="text"> LOGIN</h1>
     <br>
     <input v-model="email" type="text" placeholder="Enter Email" />
     <input v-model="password" type="password" placeholder="Enter Password" />
     <button v-on:click="login()"> LOGIN</button>
    </div>
    </template>
        
    <script>
import axios from 'axios'
import { useMyStore } from '@/store/navbar.js'
import {toast} from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

        export default {
          name: 'LoginComponent',
          data()
          {
            return {
                email: '',
                password: '',
            }

          },
          methods:{
            incorrectCredsToast()
            {
              toast.error('Incorrect email or password',{
                autoClose:2000,
              });
            },

             async login()
          {
            try{
            let result = await axios.post("http://127.0.0.1:8000/api/login", {
              email: this.email,
              password: this.password,
            });

            if(result.status == 200)
            {
            const userStore = useMyStore();
            localStorage.setItem("user-token", JSON.stringify(result.data.token));
            userStore.setUserInfo();
            this.$router.push({name:'Home'});
            }
            }
            catch(error){

              if (error.response.status == 401) {
                this.incorrectCredsToast();
               } 
            }
          }
        

          },
            mounted()
          {
            let user = localStorage.getItem('user-token');
            if(user)
            {
              this.$router.push({name:'Home'});
            }
          }
     }

        </script>
        <!-- Add "scoped" attribute to limit CSS to this component only -->
        <style scoped>
 
        .register input{
         width: 300px;
         height: 40px;
         padding-left: 20px;
         display: block;
         margin-bottom: 10px;
         margin-left: auto;
         margin-right: auto;
         border: 1px solid skyblue;
 
        }
    
    .register button{
     width: 300px;
     height: 40px;
     border: 1px solid skyblue;
     color: #fff;
     background-color: darkcyan;
     cursor: pointer;    
 
    }
 
    #text{
 
     color: darkcyan;
    }
        </style>
        