  <template>
   <div class="register">
    <br><br>
    <h1 id="text"> SIGN UP</h1>
    <br>
    <input type="text" v-model="name" placeholder="Enter Name"/>
    <input type="text" v-model="email" placeholder="Enter Email"/>
    <input type="password" v-model="password" placeholder="Enter Password"/>
    <input type="password" v-model="cpassword" placeholder="Confirm Password"/>
    <button v-on:click="signUp()"> SIGNUP</button>
   </div>
  </template>     
      <script>
import axios from 'axios'
import { useMyStore } from '@/store/navbar.js'
import {toast} from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

       export default {
         name: 'SignUp',
         data()
         {
          return{
            name:'',
            email:'',
            password:'',
            cpassword:'',
            emailMessage: '',
          }
         },
         methods: {
            passwordDontMatchToast()
            {
              toast.error('Passwords donot match',{
                autoClose:2000,
              });
            },
              emptyFieldToast()
            {
              toast.error('No empty field!',{
                autoClose:2000,
              });
            },
           customEmailToast()
            {
              toast.error(this.emailMessage,{
                autoClose:2000,
              });
            },

       async signUp()
          {
            try{
            //auth check first
            if(!this.name || !this.email || !this.password || !this.cpassword)
            {
              this.emptyFieldToast();
            }
           else if(this.password !== this.cpassword)
            {
              this.passwordDontMatchToast();
            }
            
            else
            {
            let result = await axios.post("http://127.0.0.1:8000/api/register", {
              name: this.name, 
              email: this.email,
              password: this.password,
            });
            if(result.status == 201)      
            {
            const userStore = useMyStore();
            localStorage.setItem("user-token", JSON.stringify(result.data.token));
            userStore.setUserInfo();
            this.$router.push({name:'Home'});
            }    
           }
          }catch(error){
            if(error.response.status == 422) {
              this.emailMessage = error.response.data.errors.email;
            if(error.response.data.errors.email)
            {
              this.customEmailToast();
              }
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
       