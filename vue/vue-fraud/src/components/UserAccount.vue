<template>
<br>
<h1>My Account</h1>
<br>
<br>
<div class="container">
      <div class="row">
        <div class="border-end   col-md-6">
          <div class=" my-3 pt-2 pb-2 ">
            <div>
              
             <h5>PROFILE PICTURE</h5>
<br>
             <img :src="picture" alt="IMAGE" id="img" class="rounded-circle" ><br><br>
              <input class="ps-5" type="file" @change="handleFileUpload" />
<br>
              <button class="btn btn-success pt-1 pb-1 mt-2" v-on:click="changePicture()">CHANGE</button>

            </div>
          </div>
        </div>
<div class="col-md-6">
          <div class=" my-3 pt-2 pb-2 ">
            <div class=" ps-5 ">
           <h5>ACCOUNT DETAILS </h5>
           <br>
          <div class=" ps-5 text-start"> 
           <b>
              Name: {{name}} <br>
              Email: {{email}}
            </b>
            </div>  
            </div>
          </div>
        </div>

      </div>
    </div>

</template>

<script>
import axios from 'axios'
export default{
    name: 'UserAccount',

    data()
    {
        return{
            name: '', 
            email: '',
            picture: '',    
            newImage: null,
        }

    },
  methods:{
    handleFileUpload(event)
      {
        this.newImage = event.target.files[0];
      },
      
  async changePicture()
  {
    if(this.newImage == null)
    {
      alert('no image');
    }
    else
    {
      let userToken = localStorage.getItem('user-token');
      userToken = userToken.replace(/^"(.*)"$/, '$1');
      let formData = new FormData();
      formData.append('image', this.newImage);
     await axios.post("http://127.0.0.1:8000/api/changepicture",formData, 
     {
        headers:{
            'Authorization': `Bearer ${userToken}`,
            'Content-Type': 'multipart/form-data'
        }
     }); 
      this.newImage = '';
     this.refreshApiCall();
    }
  },

 async refreshApiCall()
      {
    let userToken = localStorage.getItem('user-token');
        userToken = userToken.replace(/^"(.*)"$/, '$1');
         const result = await axios.get("http://127.0.0.1:8000/api/accountdata", {
          headers:{
            'Authorization': `Bearer ${userToken}`
          }
        }); 
        this.name = result.data.name;
        this.email = result.data.email;
        this.picture = result.data.image;
      }
  },

     async mounted()
      {
        let userToken = localStorage.getItem('user-token');
        if(!userToken)
        {
          this.$router.push({name:'Home'});
        }
        else
       {
        userToken = userToken.replace(/^"(.*)"$/, '$1');
      const result = await axios.get("http://127.0.0.1:8000/api/accountdata", {
          headers:{
            'Authorization': `Bearer ${userToken}`
          }
        }); 
        this.name = result.data.name;
        this.email = result.data.email;
        this.picture = result.data.image;
      }
   },
}
</script>
<style scoped>
#img{

  width: 220px; 
  height: 200px;

}

</style>