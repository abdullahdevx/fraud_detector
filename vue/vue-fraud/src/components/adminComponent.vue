<template>
    <br>
    <h1>ADMIN PANEL</h1>
    <div id="button-container">
    <button id="add" type="button" class="btn btn-success" @click="showModal = true">ADD APP</button>
    </div>
    <br>
    <br>
 <div class="container">
        <div class="row">
          <div v-for="result in data" :key="result.id" class="col-md-2">
            <div class="border my-3 pt-1 pb-1 ">
              <div>
                <img :src="result.picture" alt="IMAGE" id="img123" class="rounded"><br>
                {{result.title}}<br>
                <div class="d-flex justify-content-center">
                        <star-rating class="content-center" :show-rating="false" :rating="result.totalRating" :max-rating="5" :star-size="18"></star-rating>
                    </div>
                  
                <button class="btn btn-danger ps-1 pe-1 pt-1 pb-1 mt-2" v-on:click="deleteEntity(result.id)"> DELETE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <br>
    <!-- MODAL -->
    <div class="add">
    <div id="myModal" class="modal" v-if="showModal">
    <!-- Modal content FOR ADDING APP-->
    <div class="modal-content">
      <span class="close" @click="showModal = false">&times;</span>
      <form id="appForm">
        <!--form fields-->
        <h3>ADD AN APP</h3>
        <input required v-model="title" type="text" placeholder="Enter Title" style="width: 400px; " />
     <textarea v-model="description" type="text" placeholder="   Enter Description" style="width: 400px; height: 130px;"></textarea>
     <input @change="handleFileUpload" class="fileUpload" type="file" placeholder="Enter Description" />
     <input v-model="url" type="text" placeholder="App URL" style="width: 400px;"/>
     <button class="btn btn-success" v-on:click.prevent="submitApp()"> SUBMIT</button>
      </form>
    </div>
  </div>
  </div>

</template>

<script>
import axios from 'axios'
import {useMyStore} from '@/store/navbar.js'
import {toast} from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import StarRating from 'vue-star-rating';


export default {
    name: 'adminComponent',
    data()
    {
        return {
            title: '',
            description: '',
            url: '',
            showModal: false,
            data: null,
            image: null,
        }
    }, 
  components:{
        StarRating

  },

    methods: {
       successReviewToast()
          {
            toast.success('Added Successfully',{
              autoClose: 2000,
            });
          },

      async deleteEntity(id)
      {
        let result = await axios.post(`http://127.0.0.1:8000/api/deleteadmin/${id}`);
        if(result.status == 200)
        {
          alert('DELETED SUCCESSFULLY!');
          this.fetchData();
        }

      },

      //TO REFRESH THE COMPONENT
      async fetchData() {
        const result = await axios.get("http://127.0.0.1:8000/api/home");
        this.data = result.data.data;
      },

      handleFileUpload(event)
      {
        this.image = event.target.files[0];
      },

        async submitApp()
        {   
          if (!this.title || !this.description || !this.url || !this.image) {
            alert('All fields are required');
          }
          else{
      let formData = new FormData();

        formData.append('title', this.title);
        formData.append('description', this.description);
        formData.append('url', this.url); 
        formData.append('image', this.image);

                // console.log(formData);
            let result = await axios.post("http://127.0.0.1:8000/api/createadmin",formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
            });


            if(result.status == 201)
            {
                // alert('App Added Successfully');
                this.showModal = false;
                this.fetchData();
                this.successReviewToast();
            }
             }
        }
    }, 

async mounted()
    {
      try{
      let userToken = localStorage.getItem('user-token');
        if(!userToken)
        {
          this.$router.push({name:'Home'});
        }
      else{
        userToken = userToken.replace(/^"(.*)"$/, '$1');
         await axios.get("http://127.0.0.1:8000/api/checkrole", {
          headers:{
            'Authorization': `Bearer ${userToken}`
          }
        }); 
        
      const result = await axios.get("http://127.0.0.1:8000/api/home");
      this.data = result.data.data;
        if(result.status == 200)
        {
                const userStore = useMyStore();
                userStore.isAdmin = true;
            
        }
      }
    }catch(error)
    {
      if(error.response.status == 401)
      {
        this.$router.push({name:'Home'});

      }

    }
    },

}
</script>
<style scoped>
#button-container {
  text-align: right;
}

#add {
  margin-right: 80px; /* Adjust this value as needed */
}

#main {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.review {
  flex-basis: calc(25% - 10px);
  border: 1px solid #ccc;
  margin-bottom: 10px;
  padding: 10px;
}
#img123{
   width: 150px;
  height: 150px;

}
/* The Modal (background) */
.modal {
  display: block; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height: 90%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.add input{
         width: 300px;
         height: 40px;
         padding-left: 20px;
         display: block;
         margin-bottom: 10px;
         margin-left: auto;
         margin-right: auto;
         /* border: 1px solid skyblue; */
 
}

#img{
  
width: 209px;
  height: 200px;

}

</style>